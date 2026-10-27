<?php

namespace App\Mail\Web;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Atendimento extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private array $data
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Contato via site',
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            to: [
                new Address(
                    $this->data['contact_to'] ?? config('mail.contact_to') ?? config('mail.from.address'),
                    config('mail.from.name')
                ),
            ],
            replyTo: [
                new Address($this->data['reply_email'], $this->data['reply_name']),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.atendimento',
            text: 'emails.atendimento-text',
            with: [
                'nome' => $this->data['reply_name'],
                'email' => $this->data['reply_email'],
                'whatsapp' => $this->data['whatsapp'] ?? null,
                'mensagem' => $this->data['mensagem'],
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
