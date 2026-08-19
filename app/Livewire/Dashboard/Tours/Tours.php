<?php

namespace App\Livewire\Dashboard\Tours;

use App\Livewire\Concerns\WithSafeSorting;
use App\Models\Tour;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Tours extends Component
{
    use WithPagination, WithSafeSorting;

    protected $paginationTheme = 'bootstrap';
    public int $perPage = 24;
    public string $search = '';
    #[Locked]
    public string $sortField = 'title';
    #[Locked]
    public string $sortDirection = 'desc';
    public ?int $delete_id = null;  

    #{Url}
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    protected function sortableFields(): array
    {
        return ['title', 'price', 'created_at', 'active', 'tour_type'];
    }

    protected function defaultSortField(): string
    {
        return 'title';
    }

    public function loadMore()
    {
        $this->perPage += 12; // aumenta a quantidade de itens carregados
    }

    public function toggleStatus($id)
    {              
        $tour = Tour::findOrFail($id);
        $this->authorize('update', $tour);
        $tour->active = !$tour->active;
        $tour->save();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Passeio?',
            'text' => 'Essa ação não pode ser desfeita.!',
            'showConfirmButton' => false,
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteTour',
            'confirmParams' => [$id],
        ]);       
    }

    #[On('deleteTour')]
    public function deleteTour($id): void
    {
        try {
            $tour = Tour::findOrFail($id);           
            $this->authorize('delete', $tour);
            $tour->delete();

            $this->delete_id = null;

            $this->dispatch('swal:success', [
                'title' => 'Excluído!',
                'text' => 'Passeio removido com sucesso!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Não foi possível excluir o passeio.',
            ]);
        }
    }

    public function mount()
    {
        $this->authorize('viewAny', Tour::class);
    }

    public function render()
    {
        $searchableFields = ['title','tour_type'];
        $tours = Tour::with([
            'vessel',
            'images'
        ])

        // ->when(
        //     auth()->user()->isManager(),
        //     fn ($query) => $query->where(
        //         'company_id',
        //         auth()->user()->company_id
        //     )
        // )

        ->when($this->search, function ($query) use ($searchableFields) {

            $query->where(function ($q) use ($searchableFields) {

                foreach ($searchableFields as $field) {

                    $q->orWhere($field, 'LIKE', "%{$this->search}%");
                }
            });
        })

        ->orderBy($this->safeSortField(), $this->safeSortDirection())

        ->paginate($this->perPage);

        return view('livewire.dashboard.tours.tours', [
            'tours' => $tours
        ])->with('title', 'Lista de passeios');
    }
}
