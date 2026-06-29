<?php

namespace App\Observers;

use App\Enums\PaymentStatusEnum;
use App\Models\Booking;
use App\Services\Booking\BookingConfirmationService;

class BookingObserver
{
    public function saved(Booking $booking): void
    {
        if (
            !$booking->wasChanged('payment_status')
        ) {
            return;
        }

        if (
            $booking->payment_status !== PaymentStatusEnum::PAID
        ) {
            return;
        }

        app(BookingConfirmationService::class)
            ->handlePaidBooking($booking);
    }
}