<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Livewire\Web\Checkout\CheckoutForm;
use App\Enums\PaymentStatusEnum;
use App\Enums\BookingStatusEnum;
use App\Enums\TourDateStatusEnum;
use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Services\Booking\BookingPaidService;
use App\Services\MercadoPagoService;
use App\Services\PagBankService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    public function mercadopago(Request $request, MercadoPagoService $mp, BookingPaidService $bookingPaidService)
    {
        $secret    = config('services.mercadopago.webhook_secret');
        $signature = $request->header('x-signature');
        $requestId = $request->header('x-request-id');
        $dataId    = $request->input('data.id') ?? $request->query('id');

        if (!$secret) {
            Log::critical('MP Webhook: MP_WEBHOOK_SECRET não configurado');
            return response()->json(['error' => 'Webhook not configured'], 500);
        }

        if (!$signature || !$requestId) {
            Log::warning('MP Webhook: headers de assinatura ausentes');
            return response()->json(['error' => 'Missing signature'], 401);
        }

        $parts = collect(explode(',', $signature))
            ->mapWithKeys(function ($part) {
                [$key, $value] = array_pad(explode('=', $part, 2), 2, null);
                return [trim($key) => trim($value)];
            });

        $ts = $parts->get('ts');
        $v1 = $parts->get('v1');

        if (!$ts || !$v1) {
            Log::warning('MP Webhook: assinatura sem ts/v1');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        if (abs(now()->timestamp - (int) $ts) > 300) {
            Log::warning('MP Webhook: timestamp fora da janela permitida');
            return response()->json(['error' => 'Expired signature'], 401);
        }

        $manifest = "id:{$dataId};request-id:{$requestId};ts:{$ts};";
        $hash = hash_hmac('sha256', $manifest, $secret);

        if (!hash_equals($hash, $v1)) {
            Log::warning('MP Webhook assinatura inválida');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $type = $request->input('type') ?? $request->query('topic');

        if ($type !== 'payment') {
            return response()->json(['ok' => true]);
        }

        if (!$dataId) {
            return response()->json(['error' => 'No payment id'], 400);
        }

        // ✅ nunca confia no payload — sempre confirma na API do MP
        $payment = $mp->getPayment($dataId);

        $bookingUuid = $payment['external_reference'] ?? null;
        $status      = $payment['status'] ?? null;

        if (!$bookingUuid) {
            return response()->json(['error' => 'No external reference'], 400);
        }

        $booking = Booking::where('uuid', $bookingUuid)->first();

        if (!$booking) {
            Log::warning("Booking não encontrado para uuid: {$bookingUuid}");
            return response()->json(['error' => 'Booking not found'], 404);
        }

        // ✅ confere o valor pago contra o total da reserva
        $paidAmount   = (float) ($payment['transaction_amount'] ?? 0);
        $bookingTotal = (float) $booking->total;

        if ($paidAmount < $bookingTotal) {
            Log::warning('MP Webhook: valor pago menor que o total da reserva', [
                'booking_uuid' => $bookingUuid,
                'paid'         => $paidAmount,
                'expected'     => $bookingTotal,
            ]);
            return response()->json(['error' => 'Amount mismatch'], 409);
        }

        if (!$booking->payment_id) {
            $booking->update(['payment_id' => $payment['id']]);
        }

        match ($status) {
            'approved'  => $this->handleApproved($booking, $bookingPaidService),
            'rejected', 'cancelled' => $this->handleFailed($booking, $bookingPaidService, $status),
            'expired'   => $this->handleExpired($booking, $bookingPaidService),
            'refunded'  => $this->handleRefunded($booking),
            default => Log::info("MP Webhook status ignorado: {$status}", ['uuid' => $bookingUuid]),
        };

        return response()->json(['ok' => true]);
    }

    protected function handleApproved(Booking $booking, BookingPaidService $service): void
    {
        if ($booking->status === BookingStatusEnum::CANCELLED
            || in_array($booking->payment_status, [
                PaymentStatusEnum::REFUNDED,
                PaymentStatusEnum::REFUSED,
                PaymentStatusEnum::EXPIRED,
            ], true)) {
            Log::warning('MP Webhook: approved ignorado para booking em estado final', [
                'booking_id'     => $booking->id,
                'status'         => $booking->status->value,
                'payment_status' => $booking->payment_status->value,
            ]);
            return;
        }

        $service->handle($booking);
    }

    protected function handleFailed(Booking $booking, BookingPaidService $service, string $status): void
    {
        if ($booking->payment_status === PaymentStatusEnum::PAID) {
            Log::warning('MP Webhook: rejected/cancelled ignorado para booking pago', [
                'booking_id' => $booking->id,
            ]);
            return;
        }

        $service->handleFailed($booking, $status);
    }

    protected function handleExpired(Booking $booking, BookingPaidService $service): void
    {
        if ($booking->payment_status === PaymentStatusEnum::PAID) {
            return;
        }

        $service->handleExpired($booking);
    }

    private function handleRefunded(Booking $booking): void
    {
        if ($booking->payment_status === PaymentStatusEnum::REFUNDED) {
            return; // idempotência
        }

        if ($booking->payment_status !== PaymentStatusEnum::PAID) {
            Log::warning('MP Webhook: refunded ignorado para booking não pago', [
                'booking_id' => $booking->id,
            ]);
            return;
        }

        $booking->update([
            'payment_status' => PaymentStatusEnum::REFUNDED,
            'status'         => BookingStatusEnum::CANCELLED,
        ]);

        // Devolve as vagas
        $booking->tourDate()->increment('available_slots', $booking->adults + $booking->children + $booking->children_free);

        // Se a data estava FULL, reabre
        $tourDate = $booking->tourDate()->first();
        if ($tourDate->status === \App\Enums\TourDateStatusEnum::FULL) {
            $tourDate->update(['status' => \App\Enums\TourDateStatusEnum::OPEN]);
        }
    }

    public function pagbank(Request $request, PagBankService $pagBank, BookingPaidService $bookingPaidService)
    {
        $orderId = $request->input('id')
            ?? $request->input('resource.id')
            ?? $request->input('order.id')
            ?? $request->input('resource');

        if (!$orderId) {
            return response()->json(['ok' => true]);
        }

        $order = $pagBank->getPayment($orderId);

        $booking = Booking::where('payment_id', $orderId)->first();

        if (!$booking) {
            Log::warning("PagBank Webhook: booking não encontrado para order {$orderId}");
            return response()->json(['ok' => true]);
        }

        $charge = $order['charges'][0] ?? [];
        $status = strtoupper((string) ($charge['status'] ?? ''));

        match ($status) {
            'PAID'     => $bookingPaidService->handle($booking),
            'DECLINED', 'CANCELED' => $bookingPaidService->handleFailed($booking, $status),
            'REFUNDED' => $this->handlePagBankRefunded($booking),
            default    => Log::info("PagBank Webhook status ignorado: {$status}", ['order' => $orderId]),
        };

        return response()->json(['ok' => true]);
    }

    private function handlePagBankRefunded(Booking $booking): void
    {
        if ($booking->payment_status === PaymentStatusEnum::REFUNDED) {
            return;
        }

        if ($booking->payment_status !== PaymentStatusEnum::PAID) {
            return;
        }

        $booking->update([
            'payment_status' => PaymentStatusEnum::REFUNDED,
            'status'         => BookingStatusEnum::CANCELLED,
        ]);

        $tourDate = $booking->tourDate()->first();

        if ($tourDate) {
            $tourDate->increment('available_slots', $booking->adults + $booking->children + $booking->children_free);

            if ($tourDate->status === TourDateStatusEnum::FULL) {
                $tourDate->update(['status' => TourDateStatusEnum::OPEN]);
            }
        }
    }
}
