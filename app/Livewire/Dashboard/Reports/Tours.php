<?php

namespace App\Livewire\Dashboard\Reports;

use App\Models\Company;
use App\Models\Tour;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Tours extends Component
{
    use WithPagination;

    public $period = '30';

    public $companyFilter = '';

    public $statusFilter = '';

    public $search = '';

    public $totalTours = 0;

    public $activeTours = 0;

    public $inactiveTours = 0;

    public $withoutDates = 0;

    public $totalBookings = 0;

    public $totalRevenue = 0;

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
        $startDate = now()->subDays((int) $this->period)->startOfDay();

        $baseQuery = Tour::query()
            ->when($this->companyFilter, fn ($q) => $q->where('company_id', $this->companyFilter))
            ->when($this->statusFilter !== '', fn ($q) => $q->where('active', $this->statusFilter === 'active'));

        $this->totalTours    = (clone $baseQuery)->count();
        $this->activeTours   = (clone $baseQuery)->where('active', true)->count();
        $this->inactiveTours = (clone $baseQuery)->where('active', false)->count();
        $this->withoutDates  = (clone $baseQuery)->doesntHave('tourDates')->count();

        $this->totalBookings = (clone $baseQuery)
            ->withCount(['bookings as c' => fn ($q) => $q->where('payment_status', 'paid')])
            ->get()
            ->sum('c');

        $this->totalRevenue = (clone $baseQuery)
            ->withSum(['bookings as r' => fn ($q) => $q->where('payment_status', 'paid')], 'total')
            ->get()
            ->sum('r');

        $tours = Tour::query()
            ->when($this->companyFilter, fn ($q) => $q->where('company_id', $this->companyFilter))
            ->where('created_at', '>=', $startDate)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $this->labels = $tours->pluck('month')
            ->map(fn ($m) => Carbon::createFromFormat('Y-m', $m)->translatedFormat('M/Y'))
            ->values()
            ->all();

        $this->data = $tours->pluck('total')->values()->all();

        $this->dispatch('updateChart', [
            'labels' => $this->labels,
            'data'   => $this->data,
        ]);
    }

    public function render()
    {
        $tours = Tour::query()
            ->with(['company', 'vessel'])
            ->withCount(['bookings as bookings_count' => fn ($q) => $q->where('payment_status', 'paid')])
            ->withSum(['bookings as revenue' => fn ($q) => $q->where('payment_status', 'paid')], 'total')
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->companyFilter, fn ($q) => $q->where('company_id', $this->companyFilter))
            ->when($this->statusFilter !== '', fn ($q) => $q->where('active', $this->statusFilter === 'active'))
            ->latest()
            ->paginate(15);

        return view('livewire.dashboard.reports.tours', [
            'tours'     => $tours,
            'companies' => Company::orderBy('alias_name')->get(['id', 'alias_name']),
        ])->with('title', 'Relatório de Passeios');
    }
}