<?php

namespace App\Services\Booking;

use App\Enums\TourDateStatusEnum;
use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Booking;
use App\Mail\BookingCancelled;
use App\Notifications\Customer\BookingCancelledNotification;
use App\Services\MercadoPagoService;
use App\Services\Wallet\WalletService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingCancellationService
{
    public function __construct(
        protected WalletService $walletService,
        protected MercadoPagoService $mercadoPagoService
    ) {
    }

    public function handle(Booking $booking, ?string $reason = null): void
    {
        $booking->refresh();

        if ($booking->status === BookingStatusEnum::CANCELLED) {
            Log::info('BookingCancellationService: booking já estava cancelado, ignorando', [
                'booking_id' => $booking->id,
            ]);
            return;
        }

        $wasPaid = $booking->payment_status === PaymentStatusEnum::PAID;

        DB::transaction(function () use ($booking, $reason, $wasPaid) {
            $tourDate = $booking->tourDate()->lockForUpdate()->first();
            $seats    = $booking->adults + $booking->children + $booking->children_free;

            $tourDate->increment('available_slots', $seats);
            $tourDate->refresh();

            if ($tourDate->status === TourDateStatusEnum::FULL && $tourDate->available_slots > 0) {
                $tourDate->update(['status' => TourDateStatusEnum::OPEN]);
            }

            if ($wasPaid) {
                $this->walletService->reverseSale($booking);
            }

            $booking->update([
                'status'               => BookingStatusEnum::CANCELLED,
                'payment_status'       => $wasPaid ? PaymentStatusEnum::REFUNDED : $booking->payment_status,
                'cancelled_at'         => now(),
                'cancellation_reason'  => $reason,
            ]);
        });

        if ($wasPaid) {
            $this->refundPayment($booking);
        }

        $booking->tourDate->tour->company->owner?->notify(
            new BookingCancelledNotification($booking)
        );

        Mail::to($booking->customer_email)
            ->queue(new BookingCancelled($booking->fresh(), $booking->customer));

        Log::info('BookingCancellationService executado com sucesso', [
            'booking_id' => $booking->id,
            'reason' => $reason,
            'was_paid' => $wasPaid,
        ]);
    }

    protected function refundPayment(Booking $booking): void
    {
        if (!$booking->payment_id) {
            Log::warning('BookingCancellationService: booking pago sem payment_id, não é possível estornar no MP', [
                'booking_id' => $booking->id,
            ]);
            return;
        }

        $result = $this->mercadoPagoService->refundPayment($booking->payment_id);

        if (!$result['success']) {
            Log::error('BookingCancellationService: falha ao solicitar reembolso no Mercado Pago', [
                'booking_id' => $booking->id,
                'payment_id' => $booking->payment_id,
                'error' => $result['message'] ?? null,
                'data' => $result['data'] ?? null,
            ]);
            return;
        }

        Log::info('BookingCancellationService: reembolso solicitado com sucesso no Mercado Pago', [
            'booking_id' => $booking->id,
            'payment_id' => $booking->payment_id,
        ]);
    }

    /**
     * Pix que expirou sem pagamento.
     */
    public function handleExpired(Booking $booking): void
    {
        $booking->refresh();

        if ($booking->payment_status === PaymentStatusEnum::PAID) {
            return;
        }

        $booking->update([
            'status'         => BookingStatusEnum::CANCELLED,
            'payment_status' => PaymentStatusEnum::EXPIRED,
        ]);

        Log::info('Booking expirado (Pix não pago a tempo)', [
            'booking_id' => $booking->id,
        ]);
    }
}