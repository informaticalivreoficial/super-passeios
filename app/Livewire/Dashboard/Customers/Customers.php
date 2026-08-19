<?php

namespace App\Livewire\Dashboard\Customers;

use App\Enums\PaymentStatusEnum;
use App\Models\Company;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public string $companyFilter = '';

    public string $statusFilter = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCompanyFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
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

    public function render()
    {
        $customers = Customer::query()
            ->with(['company'])
            ->withCount(['bookings as bookings_count' => fn ($q) => $q->where('payment_status', PaymentStatusEnum::PAID)])
            ->withSum(['bookings as revenue' => fn ($q) => $q->where('payment_status', PaymentStatusEnum::PAID)], 'total')
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('cpf', 'like', "%{$this->search}%");
                });
            })
            ->when($this->companyFilter, fn ($q) => $q->where('company_id', $this->companyFilter))
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter === 'active'))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(20);

        $metrics = [
            'total'      => Customer::count(),
            'active'     => Customer::where('status', true)->count(),
            'inactive'   => Customer::where('status', false)->count(),
            'withBookings' => Customer::has('bookings')->count(),
            'withoutBookings' => Customer::doesntHave('bookings')->count(),
            'today'      => Customer::whereDate('created_at', today())->count(),
            'month'      => Customer::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'revenue'    => Customer::whereHas('bookings', fn ($q) => $q->where('payment_status', PaymentStatusEnum::PAID))
                ->withSum(['bookings as r' => fn ($q) => $q->where('payment_status', PaymentStatusEnum::PAID)], 'total')
                ->get()
                ->sum('r'),
        ];

        $companies = Company::orderBy('alias_name')->get(['id', 'alias_name']);

        return view('livewire.dashboard.customers.customers', [
            'customers' => $customers,
            'metrics'   => $metrics,
            'companies' => $companies,
        ])->with('title', 'Monitoramento de Clientes');
    }
}