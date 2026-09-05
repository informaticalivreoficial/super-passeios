<?php

namespace App\Livewire\Dashboard\Documents;

use App\Models\OperatorDocument;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentAcceptances extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public OperatorDocument $document;
    public string $search = '';
    public string $statusFilter = '';

    public function mount(OperatorDocument|int|null $document = null): void
    {
        $this->document = $document instanceof OperatorDocument
            ? $document
            : OperatorDocument::findOrFail($document);
        $this->authorize('viewAcceptances', $this->document);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $service = app(\App\Services\OperatorDocumentService::class);
        $statusMap = $service->getAllOperatorsWithStatus($this->document);

        $acceptances = $this->document->acceptances()
            ->with('customer')
            ->whereNotNull('accepted_at')
            ->orderByDesc('accepted_at');

        if ($this->search) {
            $acceptances->whereHas('customer', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        $acceptances = $acceptances->paginate(20);

        return view('livewire.dashboard.documents.document-acceptances', [
            'document'    => $this->document,
            'acceptances' => $acceptances,
            'statusMap'   => $statusMap,
        ])->layout('components.layouts.app', [
            'title' => 'Aceites - ' . $this->document->title,
        ]);
    }
}
