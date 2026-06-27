<?php

namespace App\Livewire\Dashboard\Vessels;

use App\Models\Vessel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Vessels extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 24;

    public string $search = '';

    public string $sortField = 'name';

    public string $sortDirection = 'desc';

    public ?int $delete_id = null;       

    #{Url}
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 12; // aumenta a quantidade de itens carregados
    }

    public function toggleStatus($id)
    {              
        $vessel = Vessel::findOrFail($id);
        $this->authorize('update', $vessel);
        $vessel->active = !$vessel->active;
        $vessel->save();
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

    public function applyWatermark(Vessel $vessel)
    {      
        if (!$vessel || !$vessel->company->watermark) {
            $this->dispatch('swal:error', [
                'title' => false,
                'text' => 'Nenhuma marca d’água configurada!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
            return;
        }

        $this->authorize('update', $vessel);

        $watermarkPath = storage_path('app/public/' . $vessel->company->watermark);

        if (!file_exists($watermarkPath)) {
            $this->dispatch('swal:error', [
                'title' => false,
                'text' => 'Arquivo de marca d’água não encontrado!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
            return;
        }

        $manager = new ImageManager(new Driver());

        $watermark = $manager->read($watermarkPath);

        foreach ($vessel->images as $image) {

            if ($image->watermark) {
                continue; // pula se já tiver marca
            }

            $imagePath = storage_path('app/public/' . $image->path);

            if (file_exists($imagePath)) {

                $img = $manager->read($imagePath);
                $img->place($watermark, 'bottom-right', 30, 30);
                $img->save($imagePath);

                $image->update([
                    'watermark' => true
                ]);
            }
        }        

        $this->dispatch('swal:success', [
            'title' => false,
            'text' => 'Marca d’água aplicada!',
            'timer' => 2000,
            'showConfirmButton' => false
        ]);        

        $vessel->refresh();
    }

    public function mount()
    {
        $this->authorize('viewAny', Vessel::class);
    }

    public function render()
    {
        $searchableFields = ['name','type'];
        $vessels = Vessel::with([
            'company',
            'images'
        ])

        ->when(
            auth()->user()->isManager(),

            fn ($query) => $query->where(
                'company_id',
                auth()->user()->company_id
            )
        )

        ->when($this->search, function ($query) use ($searchableFields) {

            $query->where(function ($q) use ($searchableFields) {

                foreach ($searchableFields as $field) {

                    $q->orWhere($field, 'LIKE', "%{$this->search}%");
                }
            });
        })

        ->orderBy($this->sortField, $this->sortDirection)

        ->paginate($this->perPage);

        return view('livewire.dashboard.vessels.vessels',[
            'vessels' => $vessels
        ])->with('title', 'Lista de Embarcações');
    }
}
