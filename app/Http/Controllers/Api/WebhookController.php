<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Livewire\Web\Checkout\CheckoutForm;
use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    public function mercadopago(Request $request, MercadoPagoService $mp)
    {
        // Valida assinatura
        $secret    = config('services.mercadopago.access_token');
        $signature = $request->header('x-signature');
        $requestId = $request->header('x-request-id');

        if ($secret && $signature) {
            $parts    = explode(',', $signature);
            $ts       = str_replace('ts=', '', $parts[0] ?? '');
            $v1       = str_replace('v1=', '', $parts[1] ?? '');
            $manifest = "id:{$request->input('data.id')};request-id:{$requestId};ts:{$ts};";
            $hash     = hash_hmac('sha256', $manifest, $secret);

            if (!hash_equals($hash, $v1)) {
                Log::warning('MP Webhook assinatura inválida');
                return response()->json(['error' => 'Invalid signature'], 401);
            }
        }

        Log::info('MP Webhook recebido', $request->all());
 
        // MP envia 'payment' como tipo quando o pagamento muda de status
        if ($request->type !== 'payment') {
            return response()->json(['ok' => true]);
        }
 
        $paymentId = $request->data['id'] ?? null;
 
        if (!$paymentId) {
            return response()->json(['error' => 'No payment id'], 400);
        }
 
        // Consulta o pagamento na API do MP
        $payment = $mp->getPayment($paymentId);
 
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
 
        match ($status) {
            'approved'            => $this->handleApproved($booking, $paymentId),
            'rejected', 'cancelled' => $this->handleRejected($booking),
            'refunded'            => $this->handleRefunded($booking),
            default => Log::info("MP Webhook status ignorado: {$status}", ['uuid' => $bookingUuid]),
        };
 
        return response()->json(['ok' => true]);
    }
 
    private function handleApproved(Booking $booking, string $paymentId): void
    {
        if ($booking->payment_status->value === 'PAID') return;

        // salva o payment_id antes de confirmar
        $booking->update(['payment_id' => $paymentId]);
        $booking->refresh(); // garante que confirmBooking usa o booking atualizado

        CheckoutForm::confirmBooking($booking);

        Mail::to($booking->customer_email)
            ->queue(new BookingConfirmed($booking->fresh(), $booking->customer));
    }
 
    private function handleRejected(Booking $booking): void
    {
        $booking->update([
            'status'         => \App\Enums\BookingStatusEnum::CANCELLED,
            'payment_status' => \App\Enums\PaymentStatusEnum::REFUSED,
        ]);
    }
 
    private function handleRefunded(Booking $booking): void
    {
        $booking->update([
            'payment_status' => \App\Enums\PaymentStatusEnum::REFUNDED,
        ]);
 
        // Devolve as vagas
        $booking->tourDate->increment('available_slots', $booking->adults + $booking->children);
    }
}
