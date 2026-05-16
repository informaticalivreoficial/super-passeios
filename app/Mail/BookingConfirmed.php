<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking  $booking,
        public Customer $customer,
    ) {}

    public function envelope(): Envelope
    {
        $status = $this->booking->payment_status->value === 'PAID'
            ? 'Reserva confirmada'
            : 'Reserva recebida — aguardando pagamento';

        return new Envelope(subject: "{$status} — {$this->booking->tourDate->tour->title}");
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.booking.confirmed',
            with: [
                'booking'  => $this->booking,
                'customer' => $this->customer,
                'tour'     => $this->booking->tourDate->tour,
                'date'     => $this->booking->tourDate,
                'isPaid'   => $this->booking->payment_status->value === 'PAID',
                'loginUrl' => route('login'),
            ],
        );
    }
}