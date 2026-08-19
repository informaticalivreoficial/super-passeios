<?php

namespace App\Livewire\Dashboard\Reports;

use App\Models\Booking;
use App\Models\Company;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Bookings extends Component
{
    use WithPagination;

    public $period = '30';

    public $statusFilter = '';

    public $paymentFilter = '';

    public $companyFilter = '';

    public $search = '';

    public $totalBookings = 0;

    public $paidBookings = 0;

    public $pendingBookings = 0;

    public $cancelledBookings = 0;

    public $refundedBookings = 0;

    public $totalRevenue = 0;

    public $totalCommission = 0;

    public $averageTicket = 0;

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

    public function updatedPaymentFilter(): void
    {
        $this->loadData();
        $this->resetPage();
    }

    public function updatedCompanyFilter(): void
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

        $baseQuery = Booking::query()
            ->where('created_at', '>=', $startDate)
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->paymentFilter, fn ($q) => $q->where('payment_status', $this->paymentFilter))
            ->when($this->companyFilter, fn ($q) => $q->where('company_id', $this->companyFilter));

        $this->totalBookings    = (clone $baseQuery)->count();
        $this->paidBookings     = (clone $baseQuery)->where('payment_status', 'paid')->count();
        $this->pendingBookings  = (clone $baseQuery)->where('payment_status', 'pending')->count();
        $this->cancelledBookings = (clone $baseQuery)->where('status', 'cancelled')->count();
        $this->refundedBookings = (clone $baseQuery)->where('payment_status', 'refunded')->count();

        $this->totalRevenue    = (clone $baseQuery)->where('payment_status', 'paid')->sum('total');
        $this->totalCommission = (clone $baseQuery)->where('payment_status', 'paid')->sum('commission_amount');
        $this->averageTicket   = $this->paidBookings > 0
            ? round($this->totalRevenue / $this->paidBookings, 2)
            : 0;

        $bookings = (clone $baseQuery)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();

        $this->labels = $bookings->pluck('date')
            ->map(fn ($d) => Carbon::parse($d)->format('d/m'))
            ->values()
            ->all();

        $this->data = $bookings->pluck('total')->values()->all();

        $this->dispatch('updateChart', [
            'labels' => $this->labels,
            'data'   => $this->data,
        ]);
    }

    public function render()
    {
        $startDate = now()->subDays((int) $this->period)->startOfDay();

        $bookings = Booking::query()
            ->with(['tour', 'company'])
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('customer_name', 'like', "%{$this->search}%")
                    ->orWhere('customer_email', 'like', "%{$this->search}%")
                    ->orWhere('uuid', 'like', "%{$this->search}%");
            }))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->paymentFilter, fn ($q) => $q->where('payment_status', $this->paymentFilter))
            ->when($this->companyFilter, fn ($q) => $q->where('company_id', $this->companyFilter))
            ->where('created_at', '>=', $startDate)
            ->latest()
            ->paginate(15);

        return view('livewire.dashboard.reports.bookings', [
            'bookings'  => $bookings,
            'companies' => Company::orderBy('alias_name')->get(['id', 'alias_name']),
        ])->with('title', 'Relatório de Reservas');
    }
}