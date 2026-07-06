<?php

namespace App\Services\Booking;

use App\Enums\TourDateStatusEnum;
use App\Models\Booking;
use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Mail\BookingConfirmed;
use App\Services\Wallet\WalletService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingPaidService
{
    public function __construct(
        protected WalletService $walletService
    ) {
    }

    public function handle(Booking $booking): void
    {
        $booking->refresh();

        if ($booking->payment_status === PaymentStatusEnum::PAID) {
            Log::info('BookingPaidService: booking já estava pago, ignorando', [
                'booking_id' => $booking->id,
            ]);
            return;
        }

        DB::transaction(function () use ($booking) {
            $tourDate = $booking->tourDate()->lockForUpdate()->first();
            $seats    = $booking->adults + $booking->children;

            if ($tourDate->available_slots < $seats) {
                Log::error('BookingPaidService: vagas insuficientes no momento da confirmação', [
                    'booking_id' => $booking->id,
                    'seats' => $seats,
                    'available' => $tourDate->available_slots,
                ]);
            } else {
                $tourDate->decrement('available_slots', $seats);
                $tourDate->refresh();

                if ($tourDate->available_slots === 0) {
                    $tourDate->update(['status' => TourDateStatusEnum::FULL]);
                }
            }

            $booking->update([
                'status'         => BookingStatusEnum::CONFIRMED,
                'payment_status' => PaymentStatusEnum::PAID,
                'paid_at'        => now(),
            ]);

            $this->walletService->registerSale($booking);
        });

        Mail::to($booking->customer_email)
            ->queue(new BookingConfirmed($booking->fresh(), $booking->customer));

        Log::info('BookingPaidService executado com sucesso', [
            'booking_id' => $booking->id,
        ]);
    }

    /**
     * Cartão recusado ou Pix/pagamento cancelado.
     */
    public function handleFailed(Booking $booking, ?string $reason = null): void
    {
        $booking->refresh();

        if ($booking->payment_status === PaymentStatusEnum::PAID) {
            return;
        }

        $booking->update([
            'status'         => BookingStatusEnum::CANCELLED,
            'payment_status' => PaymentStatusEnum::REFUSED, // ✅ corrigido
        ]);

        Log::info('Booking marcado como recusado', [
            'booking_id' => $booking->id,
            'reason' => $reason,
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