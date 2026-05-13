<?php

namespace App\Livewire\Company\Vessels;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Vessel;
use Livewire\Attributes\On;

class VesselIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $delete_id = null;

    public function toggleStatus(int $id): void
    {
        $vessel = Vessel::findOrFail($id);

        // Policy
        $this->authorize('update', $vessel);

        // Alterna status
        $vessel->update([
            'active' => ! $vessel->active,
        ]);

        // Feedback
        $this->dispatch('swal:success', [
            'title'             => 'Sucesso!',
            'text'              => $vessel->active
                ? 'Embarcação ativada com sucesso!'
                : 'Embarcação desativada com sucesso!',
            'timer'             => 2000,
            'showConfirmButton' => false,
        ]);
    }    

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Embarcação?',
            'text' => 'Essa ação não pode ser desfeita.!',
            'showConfirmButton' => false,
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteVessel',
            'confirmParams' => [$id],
        ]);       
    }

    #[On('deleteVessel')]
    public function deleteVessel($id): void
    {
        try {
            $vessel = Vessel::findOrFail($id);
            $this->authorize('delete', $vessel);          

            $vessel->delete();

            $this->delete_id = null;

            $this->dispatch('swal:success', [
                'title' => 'Excluído!',
                'text' => 'Embarcação removida com sucesso!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Não foi possível excluir a embarcação.',
            ]);
        }
    }

    #[Layout('components.layouts.company', ['title' => 'Minhas Embarcações'])]
    public function render()
    {
        $vessels = auth()->user()->company->vessels()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(12);

        return view('livewire.company.vessels.vessel-index', compact('vessels'));
    }
}
