<?php

namespace App\Jobs;

use App\Models\Newsletter;
use App\Models\NewsletterCampaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBulkNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    public function __construct(
        public NewsletterCampaign $campaign,
        public ?int $categoryId = null,
        public ?array $subscriberIds = null,
    ) {}

    public function handle(): void
    {
        $query = Newsletter::query()
            ->where('active', true)
            ->whereNotNull('confirmed_at');

        if ($this->subscriberIds) {
            $query->whereIn('id', $this->subscriberIds);
        } elseif ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        $subscribers = $query->get();

        foreach ($subscribers as $subscriber) {
            $send = $this->campaign->sends()->create([
                'newsletter_id' => $subscriber->id,
                'status' => 'pending',
            ]);

            SendNewsletterJob::dispatch($send);
        }

        $this->campaign->update([
            'total_recipients' => $subscribers->count(),
            'status' => 'sent',
        ]);
    }
}
