<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterSend;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(
        public NewsletterSend $send,
    ) {}

    public function handle(): void
    {
        $subscriber = $this->send->newsletter;
        $campaign = $this->send->campaign;

        if (!$subscriber || !$subscriber->active || !$subscriber->confirmed_at) {
            $this->send->update([
                'status' => 'failed',
                'error' => 'Assinante inativo ou não confirmado.',
            ]);
            return;
        }

        Mail::mailer('mailtrap-sdk')->to($subscriber->email)->send(new NewsletterMail($campaign, $subscriber));

        $this->send->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        $this->send->update([
            'status' => 'failed',
            'error' => mb_substr($exception->getMessage(), 0, 500),
        ]);
    }
}
