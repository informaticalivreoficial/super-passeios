<?php

namespace App\Mail\Customer;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerOrderAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Customer $customer, public string $link)
    {
        //
    }

    public function build()
    {
        return $this->subject('Acesse seus pedidos')
            ->view('emails.customer.order-access')
            ->with([
                'name' => $this->customer->name,
                'link' => $this->link,
            ]);
    }
}
