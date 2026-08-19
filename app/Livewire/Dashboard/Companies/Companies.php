<?php

namespace App\Livewire\Dashboard\Companies;

use App\Livewire\Concerns\WithSafeSorting;
use App\Models\Company;
use App\Models\Config;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Companies extends Component
{
    use WithPagination, WithSafeSorting;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    #[Locked]
    public string $sortField = 'social_name';

    #[Locked]
    public string $sortDirection = 'desc';

    public ?int $delete_id = null;

    public $showCompanyModal = false;
    public $companySelected;    

    #{Url}
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    protected function sortableFields(): array
    {
        return ['social_name', 'alias_name', 'created_at', 'views', 'status'];
    }

    protected function defaultSortField(): string
    {
        return 'social_name';
    }  
    
    public function toggleHighlight(Company $company)
    {
        $company->highlight = !$company->highlight;
        $company->save();        
    }

    public function toggleStatus($id)
    {              
        $company = Company::findOrFail($id);
        $company->status = !$company->status;        
        $company->save();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Empresa?',
            'text' => 'Essa ação não pode ser desfeita.!',
            'showConfirmButton' => false,
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteCompany',
            'confirmParams' => [$id],
        ]);       
    }

    #[On('deleteCompany')]
    public function deleteCompany($id): void
    {
        try {
            $company = Company::findOrFail($id);

            $company->delete();

            $this->delete_id = null;

            $this->dispatch('swal:success', [
                'title' => 'Excluído!',
                'text' => 'Empresa removida com sucesso!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Não foi possível excluir a empresa.',
            ]);
        }
    }

    public function applyWatermark(Company $company)
    {      

        $config = Config::first();

        if (!$config || !$config->watermark) {
            $this->dispatch('swal:error', [
                'title' => false,
                'text' => "Nenhuma marca d'água configurada!",
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
            return;
        }

        $watermarkPath = storage_path('app/public/' . $config->watermark);

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

        foreach ($company->images as $image) {

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

        $company->refresh();
    }

    public function render()
    {
        $companies = Company::query()
        ->when($this->search, fn($q) => $q->where('alias_name', 'like', "%{$this->search}%"))
        ->withCount(['withdrawals as pending_withdrawals_count' => function ($query) {
            $query->whereIn('status', [\App\Enums\WithdrawalStatusEnum::REQUESTED, \App\Enums\WithdrawalStatusEnum::APPROVED]);
        }])
        ->withSum(['withdrawals as pending_withdrawals_amount' => function ($query) {
            $query->whereIn('status', [\App\Enums\WithdrawalStatusEnum::REQUESTED, \App\Enums\WithdrawalStatusEnum::APPROVED]);
        }], 'net_amount')
        ->orderBy($this->safeSortField(), $this->safeSortDirection())
        ->paginate(35);

        return view('livewire.dashboard.companies.companies', [
            'companies' => $companies,
        ])->with('title', 'Lista de Empresas');
    }
}
