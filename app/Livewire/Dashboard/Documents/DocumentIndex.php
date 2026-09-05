<?php

namespace App\Livewire\Dashboard\Documents;

use App\Enums\DocumentTypeEnum;
use App\Livewire\Concerns\WithSafeSorting;
use App\Models\OperatorDocument;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class DocumentIndex extends Component
{
    use WithPagination, WithSafeSorting;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $typeFilter = '';
    public string $statusFilter = '';

    #[Locked]
    public string $sortField = 'sort_order';

    #[Locked]
    public string $sortDirection = 'asc';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    protected function sortableFields(): array
    {
        return ['title', 'type', 'version', 'sort_order', 'is_active', 'published_at', 'created_at'];
    }

    protected function defaultSortField(): string
    {
        return 'sort_order';
    }

    public function toggleStatus(OperatorDocument $document): void
    {
        $document->update(['is_active' => !$document->is_active]);
    }

    public function confirmDeleteDocument(int $id): void
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir este documento?',
            'text' => 'Esta ação não poderá ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteDocument',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteDocument')]
    public function deleteDocument(int $id): void
    {
        $document = OperatorDocument::findOrFail($id);
        $document->delete();

        $this->dispatch('swal:success', [
            'title'             => 'Excluído!',
            'text'              => 'Documento excluído com sucesso.',
            'timer'             => 3000,
            'showConfirmButton' => false,
        ]);
    }

    public function render()
    {
        $query = OperatorDocument::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('type', 'like', "%{$this->search}%")
                  ->orWhere('version', 'like', "%{$this->search}%");
            });
        }

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        if ($this->statusFilter === 'published') {
            $query->where('is_active', true)->whereNotNull('published_at');
        } elseif ($this->statusFilter === 'draft') {
            $query->whereNull('published_at');
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false)->whereNotNull('published_at');
        }

        $documents = $query->orderBy($this->safeSortField(), $this->safeSortDirection())
            ->paginate(15);

        return view('livewire.dashboard.documents.document-index', [
            'documents'  => $documents,
            'types'      => DocumentTypeEnum::cases(),
        ])->layout('components.layouts.app', ['title' => 'Contratos e Documentos']);
    }
}
