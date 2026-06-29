<?php

namespace App\Services\Booking;

use App\Enums\TourDateStatusEnum;
use App\Models\Booking;
use App\Services\Wallet\WalletService;
use Illuminate\Support\Facades\Log;

class BookingPaidService
{
    public function __construct(
        protected WalletService $walletService
    ) {
    }

    public function handle(Booking $booking): void
    {
        Log::info('BookingPaidService executado', [
            'booking_id' => $booking->id,
        ]);

        $tourDate = $booking->tourDate()
            ->lockForUpdate()
            ->first();

        $seats = $booking->adults + $booking->children;

        if ($tourDate->available_slots < $seats) {
            throw new \RuntimeException('Não há vagas suficientes.');
        }

        $tourDate->decrement('available_slots', $seats);

        $tourDate->refresh();

        if ($tourDate->available_slots === 0) {
            $tourDate->update([
                'status' => TourDateStatusEnum::FULL,
            ]);
        }

        $this->walletService->registerSale($booking);
    }
}