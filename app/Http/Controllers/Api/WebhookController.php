<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Livewire\Web\Checkout\CheckoutForm;
use App\Enums\PaymentStatusEnum;
use App\Enums\BookingStatusEnum;
use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Services\Booking\BookingPaidService;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    public function mercadopago(Request $request, MercadoPagoService $mp, BookingPaidService $bookingPaidService)
    {
        // ✅ segredo dedicado do webhook, não o access_token
        $secret    = config('services.mercadopago.webhook_secret');
        $signature = $request->header('x-signature');
        $requestId = $request->header('x-request-id');
        $dataId    = $request->input('data.id') ?? $request->query('id');

        if ($secret && $signature) {
            $parts = collect(explode(',', $signature))
                ->mapWithKeys(function ($part) {
                    [$key, $value] = array_pad(explode('=', $part, 2), 2, null);
                    return [trim($key) => trim($value)];
                });

            $ts = $parts->get('ts');
            $v1 = $parts->get('v1');
            $manifest = "id:{$dataId};request-id:{$requestId};ts:{$ts};";
            $hash = hash_hmac('sha256', $manifest, $secret);

            if (!$ts || !$v1 || !hash_equals($hash, $v1)) {
                Log::warning('MP Webhook assinatura inválida');
                return response()->json(['error' => 'Invalid signature'], 401);
            }
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

        if (!$booking->payment_id) {
            $booking->update(['payment_id' => $payment['id']]);
        }

        match ($status) {
            'approved'  => $bookingPaidService->handle($booking),
            'rejected', 'cancelled' => $bookingPaidService->handleFailed($booking, $status),
            'expired'   => $bookingPaidService->handleExpired($booking),
            'refunded'  => $this->handleRefunded($booking),
            default => Log::info("MP Webhook status ignorado: {$status}", ['uuid' => $bookingUuid]),
        };

        return response()->json(['ok' => true]);
    }

    private function handleRefunded(Booking $booking): void
    {
        if ($booking->payment_status === PaymentStatusEnum::REFUNDED) {
            return; // idempotência
        }

        $booking->update([
            'payment_status' => PaymentStatusEnum::REFUNDED,
            'status'         => BookingStatusEnum::CANCELLED,
        ]);

        // Devolve as vagas
        $booking->tourDate()->increment('available_slots', $booking->adults + $booking->children);

        // Se a data estava FULL, reabre
        $tourDate = $booking->tourDate()->first();
        if ($tourDate->status === \App\Enums\TourDateStatusEnum::FULL) {
            $tourDate->update(['status' => \App\Enums\TourDateStatusEnum::OPEN]);
        }
    }
}
