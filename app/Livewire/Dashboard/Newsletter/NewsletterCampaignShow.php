<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Models\NewsletterCampaign;
use Livewire\Component;

class NewsletterCampaignShow extends Component
{
    public NewsletterCampaign $campaign;

    public function mount(NewsletterCampaign $campaign): void
    {
        $this->campaign = $campaign;
    }

    public function render()
    {
        $sends = $this->campaign->sends()
            ->with('newsletter')
            ->orderByDesc('sent_at')
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'total' => $sends->count(),
            'sent' => $sends->where('status', 'sent')->count(),
            'failed' => $sends->where('status', 'failed')->count(),
            'pending' => $sends->where('status', 'pending')->count(),
        ];

        return view('livewire.dashboard.newsletter.newsletter-campaign-show', [
            'sends' => $sends,
            'stats' => $stats,
        ])->with('title', 'Detalhes da Campanha');
    }
}
