<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $magicLink;

    public function __construct(
        public Booking  $booking,
        public Customer $customer,
    ) {
        // Gera um magic link novo, válido por 7 dias — o cliente entra direto
        // pra acompanhar o pedido sem precisar passar pelo "esqueci meu CPF".
        $this->customer->forceFill([
            'magic_token'            => Str::random(64),
            'magic_token_expires_at' => now()->addDays(7),
        ])->save();

        $this->magicLink = route('customer.orders.access', [
            'token' => $this->customer->magic_token,
        ]);
    }

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
                'booking'   => $this->booking,
                'customer'  => $this->customer,
                'tour'      => $this->booking->tourDate->tour,
                'date'      => $this->booking->tourDate,
                'isPaid'    => $this->booking->payment_status->value === 'PAID',
                'magicLink' => $this->magicLink,
            ],
        );
    }

    public function attachments(): array
    {
        if ($this->booking->payment_status->value !== 'PAID') {
            return [];
        }

        return [
            Attachment::fromData(
                fn () => $this->generateVoucherPdf(),
                'voucher-'.strtoupper(substr($this->booking->uuid, 0, 8)).'.pdf'
            )->withMime('application/pdf'),
        ];
    }

    protected function generateVoucherPdf(): string
    {
        $qrCodeBase64 = null;

        try {
            $qrCodeBase64 = base64_encode(
                QrCode::format('png')->size(200)->margin(1)->generate($this->booking->uuid)
            );
        } catch (\Throwable $e) {
            // segue sem QR se falhar — não trava o envio do e-mail
        }

        return Pdf::loadView('pdf.booking-voucher', [
            'booking'      => $this->booking->load('tourDate.tour', 'customer'),
            'qrCodeBase64' => $qrCodeBase64,
        ])->setPaper('a4', 'portrait')->output();
    }
}