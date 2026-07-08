<?php

namespace App\Notifications\Customer;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification
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
            'title' => 'Nova reserva recebida',
            'message' => "Você recebeu uma nova reserva para \"{$this->booking->tourDate->tour->title}\".",
            'icon' => 'calendar-plus',
            'color' => 'blue',
            'url' => route('company.bookings.show', $this->booking->id),
            'booking_id' => $this->booking->id,
        ];
    }
}
