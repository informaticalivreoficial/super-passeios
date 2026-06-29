<?php

namespace App\Services\Booking;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\TourDateStatusEnum;
use App\Models\Booking;
use App\Services\Wallet\WalletService;
use Illuminate\Support\Facades\DB;

class BookingConfirmationService
{
    public function __construct(
        protected WalletService $walletService
    ) {
    }

    public function handlePaidBooking(Booking $booking): void
    {
        DB::transaction(function () use ($booking) {

            if ($booking->tourDate->available_slots > 0) {

                $booking->tourDate->decrement(
                    'available_slots',
                    $booking->adults + $booking->children
                );

            }

            $booking->tourDate->refresh();

            if ($booking->tourDate->available_slots <= 0) {

                $booking->tourDate->update([
                    'status' => TourDateStatusEnum::FULL
                ]);

            }

            $this->walletService
                ->registerSale($booking);

        });
    }
}