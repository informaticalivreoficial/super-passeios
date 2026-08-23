<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Livewire\Concerns\WithSafeSorting;
use App\Models\NewsletterCategory;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class NewsletterCategories extends Component
{
    use WithPagination, WithSafeSorting;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    #[Locked]
    public string $sortField = 'created_at';

    #[Locked]
    public string $sortDirection = 'desc';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    protected function sortableFields(): array
    {
        return ['name', 'created_at'];
    }

    protected function defaultSortField(): string
    {
        return 'created_at';
    }

    public function toggleStatus(int $id): void
    {
        $category = NewsletterCategory::findOrFail($id);
        $category->update(['active' => !$category->active]);

        $this->dispatch('swal:success', [
            'title' => 'Atualizado!',
            'text' => $category->active ? 'Categoria ativada.' : 'Categoria desativada.',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function setDeleteId(int $id): void
    {
        $category = NewsletterCategory::withCount('newsletters')->findOrFail($id);

        $text = $category->newsletters_count > 0
            ? 'Essa categoria possui ' . $category->newsletters_count . ' e-mail(s) associado(s). Eles ficarão sem categoria. Deseja excluir mesmo assim?'
            : 'Essa ação não pode ser desfeita.';

        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Categoria?',
            'text' => $text,
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteNewsletterCategory',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteNewsletterCategory')]
    public function delete(int $id): void
    {
        try {
            NewsletterCategory::findOrFail($id)->delete();

            $this->dispatch('swal:success', [
                'title' => 'Excluído!',
                'text' => 'Categoria removida com sucesso.',
                'timer' => 2000,
                'showConfirmButton' => false,
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon' => 'error',
                'text' => 'Não foi possível excluir a categoria.',
            ]);
        }
    }

    public function render()
    {
        $categories = NewsletterCategory::query()
            ->withCount('newsletters')
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy($this->safeSortField(), $this->safeSortDirection())
            ->paginate(20);

        return view('livewire.dashboard.newsletter.categories', [
            'categories' => $categories,
        ])->with('title', 'Categorias da Newsletter');
    }
}
