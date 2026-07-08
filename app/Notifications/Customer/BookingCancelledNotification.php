<?php

namespace App\Notifications\Customer;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelledNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Reserva cancelada',
            'message' => "A reserva #{$this->booking->id} foi cancelada.",
            'icon' => 'x-circle',
            'color' => 'red',
            'url' => route('company.bookings.show', $this->booking->id),
            'booking_id' => $this->booking->id,
        ];
    }
}
