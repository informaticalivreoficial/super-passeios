<?php

namespace App\Livewire\Dashboard\Reports;

use App\Models\Company;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Companies extends Component
{
    use WithPagination;

    public $period = '30';

    public $statusFilter = '';

    public $search = '';

    public $totalCompanies = 0;

    public $activeCompanies = 0;

    public $inactiveCompanies = 0;

    public $withTours = 0;

    public $withoutTours = 0;

    public $totalRevenue = 0;

    public $totalCommission = 0;

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
        $startDate = now()->subDays((int) $this->period)->startOfDay();

        $baseQuery = Company::query()
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter === 'active'));

        $this->totalCompanies  = (clone $baseQuery)->count();
        $this->activeCompanies = (clone $baseQuery)->where('status', true)->count();
        $this->inactiveCompanies = (clone $baseQuery)->where('status', false)->count();
        $this->withTours       = (clone $baseQuery)->has('tours')->count();
        $this->withoutTours    = (clone $baseQuery)->doesntHave('tours')->count();

        $this->totalRevenue = (clone $baseQuery)
            ->withSum(['bookings as r' => fn ($q) => $q->where('payment_status', 'paid')], 'total')
            ->get()
            ->sum('r');

        $this->totalCommission = (clone $baseQuery)
            ->withSum(['bookings as c' => fn ($q) => $q->where('payment_status', 'paid')], 'commission_amount')
            ->get()
            ->sum('c');

        $companies = Company::query()
            ->where('created_at', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $this->labels = $companies->pluck('month')
            ->map(fn ($m) => Carbon::createFromFormat('Y-m', $m)->translatedFormat('M/Y'))
            ->values()
            ->all();

        $this->data = $companies->pluck('total')->values()->all();

        $this->dispatch('updateChart', [
            'labels' => $this->labels,
            'data'   => $this->data,
        ]);
    }

    public function render()
    {
        $companies = Company::query()
            ->withCount(['tours as tours_count'])
            ->withCount(['bookings as bookings_count' => fn ($q) => $q->where('payment_status', 'paid')])
            ->withSum(['bookings as revenue' => fn ($q) => $q->where('payment_status', 'paid')], 'total')
            ->when($this->search, fn ($q) => $q->where('alias_name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter === 'active'))
            ->latest()
            ->paginate(15);

        return view('livewire.dashboard.reports.companies', [
            'companies' => $companies,
        ])->with('title', 'Relatório de Empresas');
    }
}