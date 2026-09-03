<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Models\NewsletterCampaign;
use Livewire\Component;
use Livewire\WithPagination;

class NewsletterHistory extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $campaigns = NewsletterCampaign::withCount(['sends as total_sends', 'sends as sent_count' => function ($q) {
            $q->where('status', 'sent');
        }, 'sends as failed_count' => function ($q) {
            $q->where('status', 'failed');
        }])
            ->orderByDesc('created_at')
            ->paginate(15);

        $totalSent = NewsletterCampaign::sum('total_recipients');

        $totalCampaigns = NewsletterCampaign::count();

        return view('livewire.dashboard.newsletter.newsletter-history', [
            'campaigns' => $campaigns,
            'totalSent' => $totalSent,
            'totalCampaigns' => $totalCampaigns,
        ])->with('title', 'Histórico de Envios');
    }
}
