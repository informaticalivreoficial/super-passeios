<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCancelled extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public ?Customer $customer = null
    ) {
    }

    public function build()
    {
        return $this->subject('Sua reserva foi cancelada')
            ->markdown('emails.booking.booking-cancelled', [
                'booking' => $this->booking,
                'customer' => $this->customer,
            ]);
    }
}