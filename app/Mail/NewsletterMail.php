<?php

namespace App\Mail;

use App\Models\Config;
use App\Models\Newsletter;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public NewsletterCampaign $campaign,
        public Newsletter $subscriber,
    ) {}

    public function envelope(): Envelope
    {
        $newsletterConfig = NewsletterConfig::instance();

        $fromEmail = $newsletterConfig->from_email ?? config('mail.from.address');
        $fromName = $newsletterConfig->from_name ?? config('mail.from.name', config('app.name'));

        $envelope = new Envelope(
            from: $fromEmail,
            subject: $this->campaign->subject,
        );

        if ($newsletterConfig->reply_to) {
            $envelope->replyTo = [$newsletterConfig->reply_to];
        }

        return $envelope;
    }

    public function content(): Content
    {
        $newsletterConfig = NewsletterConfig::instance();
        $siteConfig = Config::where('id', 1)->first();
        $footer = $newsletterConfig->renderFooter($this->subscriber, $siteConfig);

        $bodyWithFooter = $this->campaign->body . $footer;

        return new Content(
            htmlString: $bodyWithFooter,
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
