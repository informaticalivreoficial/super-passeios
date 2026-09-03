<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Jobs\SendBulkNewsletterJob;
use App\Models\Newsletter;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterCategory;
use Livewire\Component;

class NewsletterSend extends Component
{
    public string $subject = '';

    public string $body = '';

    public ?int $categoryId = null;

    public string $search = '';

    public array $selected = [];

    public bool $selectAll = false;

    public int $recipientCount = 0;

    public bool $sending = false;

    public string $recipientMode = 'all';

    public function getCategoriesProperty()
    {
        return NewsletterCategory::where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function getSubscribersProperty()
    {
        $query = Newsletter::query()
            ->where('active', true)
            ->whereNotNull('confirmed_at');

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        return $query->orderBy('name')->get();
    }

    public function updatedCategoryId(): void
    {
        $this->selected = [];
        $this->selectAll = false;
        $this->updateRecipientCount();
    }

    public function updatedSearch(): void
    {
        $this->selected = [];
        $this->selectAll = false;
        $this->updateRecipientCount();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selected = $this->subscribers->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
        $this->updateRecipientCount();
    }

    public function updatedSelected(): void
    {
        $this->selectAll = count($this->selected) === $this->subscribers->count()
            && $this->subscribers->count() > 0;
        $this->updateRecipientCount();
    }

    public function toggleSelectAll(): void
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            $this->selected = $this->subscribers->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
        $this->updateRecipientCount();
    }

    public function updateRecipientCount(): void
    {
        if ($this->recipientMode === 'selected') {
            $this->recipientCount = count($this->selected);
        } else {
            $query = Newsletter::query()
                ->where('active', true)
                ->whereNotNull('confirmed_at');

            if ($this->categoryId) {
                $query->where('category_id', $this->categoryId);
            }

            $this->recipientCount = $query->count();
        }
    }

    public function send(): void
    {
        $this->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ], [
            'subject.required' => 'Informe o assunto do e-mail.',
            'subject.max' => 'O assunto não pode ter mais de 255 caracteres.',
            'body.required' => 'Escreva o conteúdo do e-mail.',
        ]);

        if ($this->recipientMode === 'selected' && empty($this->selected)) {
            $this->dispatch('swal:warning', [
                'title' => 'Sem destinatários!',
                'text'  => 'Selecione pelo menos um assinante para enviar.',
                'icon'  => 'warning',
            ]);
            return;
        }

        if ($this->recipientCount === 0) {
            $this->dispatch('swal:warning', [
                'title' => 'Sem destinatários!',
                'text'  => 'Não há assinantes ativos e confirmados para receberem este e-mail.',
                'icon'  => 'warning',
            ]);
            return;
        }

        $this->sending = true;

        $campaign = NewsletterCampaign::create([
            'subject' => $this->subject,
            'body' => $this->body,
        ]);

        $subscriberIds = $this->recipientMode === 'selected'
            ? $this->selected
            : null;

        SendBulkNewsletterJob::dispatch($campaign, $this->categoryId, $subscriberIds);

        $this->dispatch('swal:success', [
            'title' => 'E-mails na fila!',
            'text'  => "Campanha criada para {$this->recipientCount} destinatários. Os e-mails estão sendo enviados.",
            'timer' => 4000,
            'showConfirmButton' => false,
        ]);

        $this->reset(['subject', 'body', 'categoryId', 'search', 'selected', 'selectAll', 'recipientMode']);
        $this->recipientCount = 0;
        $this->sending = false;
    }

    public function render()
    {
        $this->updateRecipientCount();

        return view('livewire.dashboard.newsletter.newsletter-send')->with([
            'title' => 'Enviar Newsletter',
        ]);
    }
}
