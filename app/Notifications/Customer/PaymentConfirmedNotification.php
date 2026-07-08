<?php

namespace App\Notifications\Customer;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentConfirmedNotification extends Notification
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
            'title' => 'Pagamento confirmado',
            'message' => "O pagamento da reserva #{$this->booking->id} foi confirmado.",
            'icon' => 'check-circle',
            'color' => 'green',
            'url' => route('company.bookings.show', $this->booking->id),
            'booking_id' => $this->booking->id,
        ];
    }
}
