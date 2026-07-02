<?php

namespace App\Livewire\Company\Tours;

use App\Models\Tour;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class TourIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $delete_id = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus(int $id)
    {
        $tour = Tour::query()
            ->where('company_id', auth('customer')->user()->company->id)
            ->findOrFail($id);

        $tour->update([
            'active' => !$tour->active,
        ]);

        $this->dispatch('swal:success', [
            'title' => 'Sucesso',
            'text' => $tour->active
                ? 'Passeio ativado com sucesso.'
                : 'Passeio desativado com sucesso.',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
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

    #[Layout('components.layouts.company', ['title' => 'Meus Passeios', 'bracrhumb' => 'Gerencie seus passeios.'])]
    public function render()
    {
        $tours = Tour::query()
            ->with('vessel')
            ->where('company_id', auth('customer')->user()->company->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('tour_type', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(12);

        return view('livewire.company.tours.tour-index', [
            'tours' => $tours
        ]);
    }
}
