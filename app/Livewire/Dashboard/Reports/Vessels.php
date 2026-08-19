<?php

namespace App\Livewire\Dashboard\Reports;

use App\Models\Company;
use App\Models\Vessel;
use Livewire\Component;
use Livewire\WithPagination;

class Vessels extends Component
{
    use WithPagination;

    public $period = '30';

    public $companyFilter = '';

    public $statusFilter = '';

    public $search = '';

    public $totalVessels = 0;

    public $activeVessels = 0;

    public $inactiveVessels = 0;

    public $totalCapacity = 0;

    public $totalTours = 0;

    public array $labels = [];

    public array $data = [];

    public function mount()
    {
        $this->loadData();
    }

    public function updatedPeriod(): void
    {
        $this->loadData();
    }

    public function updatedCompanyFilter(): void
    {
        $this->loadData();
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->loadData();
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function loadData()
    {
        $baseQuery = Vessel::query()
            ->when($this->companyFilter, fn ($q) => $q->where('company_id', $this->companyFilter))
            ->when($this->statusFilter !== '', fn ($q) => $q->where('active', $this->statusFilter === 'active'));

        $this->totalVessels    = (clone $baseQuery)->count();
        $this->activeVessels   = (clone $baseQuery)->where('active', true)->count();
        $this->inactiveVessels = (clone $baseQuery)->where('active', false)->count();
        $this->totalCapacity   = (clone $baseQuery)->sum('capacity');
        $this->totalTours      = (clone $baseQuery)->withCount('tours')->get()->sum('tours_count');

        $types = (clone $baseQuery)
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->orderByDesc('total')
            ->get();

        $this->labels = $types->pluck('type')
            ->map(fn ($t) => $t ?: 'Não informado')
            ->values()
            ->all();

        $this->data = $types->pluck('total')->values()->all();

        $this->dispatch('updateChart', [
            'labels' => $this->labels,
            'data'   => $this->data,
        ]);
    }

    public function render()
    {
        $vessels = Vessel::query()
            ->with(['company'])
            ->withCount('tours')
            ->withCount(['tours as tours_with_bookings' => fn ($q) => $q->whereHas('bookings', fn ($b) => $b->where('payment_status', 'paid'))])
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->companyFilter, fn ($q) => $q->where('company_id', $this->companyFilter))
            ->when($this->statusFilter !== '', fn ($q) => $q->where('active', $this->statusFilter === 'active'))
            ->latest()
            ->paginate(15);

        return view('livewire.dashboard.reports.vessels', [
            'vessels'   => $vessels,
            'companies' => Company::orderBy('alias_name')->get(['id', 'alias_name']),
        ])->with('title', 'Relatório de Embarcações');
    }
}