<?php

namespace App\Livewire\Dashboard\Bookings;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Livewire\Concerns\WithSafeSorting;
use App\Models\Booking;
use App\Models\Company;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Bookings extends Component
{
    use WithPagination, WithSafeSorting;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public string $statusFilter = '';

    public string $paymentFilter = '';

    public string $methodFilter = '';

    public string $companyFilter = '';

    #[Locked]
    public string $sortField = 'created_at';

    #[Locked]
    public string $sortDirection = 'desc';

    public ?Booking $selectedBooking = null;

    public bool $showDetailModal = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedPaymentFilter(): void
    {
        $this->resetPage();
    }

    public function updatedMethodFilter(): void
    {
        $this->resetPage();
    }

    public function updatedCompanyFilter(): void
    {
        $this->resetPage();
    }

    protected function sortableFields(): array
    {
        return ['uuid', 'customer_name', 'total', 'created_at', 'status', 'payment_status'];
    }

    protected function defaultSortField(): string
    {
        return 'created_at';
    }

    public function openDetail(Booking $booking): void
    {
        $this->selectedBooking = $booking->load(['tour', 'tourDate', 'company', 'customer']);
        $this->showDetailModal = true;
    }

    public function closeDetail(): void
    {
        $this->showDetailModal = false;
        $this->selectedBooking = null;
    }

    public function render()
    {
        $bookings = Booking::query()
            ->with(['tour', 'tourDate', 'company'])
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('customer_name', 'like', "%{$this->search}%")
                        ->orWhere('customer_email', 'like', "%{$this->search}%")
                        ->orWhere('uuid', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->paymentFilter, fn ($q) => $q->where('payment_status', $this->paymentFilter))
            ->when($this->methodFilter, fn ($q) => $q->where('payment_method', $this->methodFilter))
            ->when($this->companyFilter, fn ($q) => $q->where('company_id', $this->companyFilter))
            ->orderBy($this->safeSortField(), $this->safeSortDirection())
            ->paginate(20);

        $metrics = [
            'total'      => Booking::count(),
            'today'      => Booking::whereDate('created_at', today())->count(),
            'month'      => Booking::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'pending'    => Booking::where('payment_status', PaymentStatusEnum::PENDING)->count(),
            'paid'       => Booking::where('payment_status', PaymentStatusEnum::PAID)->count(),
            'cancelled'  => Booking::where('status', BookingStatusEnum::CANCELLED)->count(),
            'revenue'    => Booking::where('payment_status', PaymentStatusEnum::PAID)->sum('total'),
            'commission' => Booking::where('payment_status', PaymentStatusEnum::PAID)->sum('commission_amount'),
        ];

        $companies = Company::orderBy('alias_name')->get(['id', 'alias_name']);

        return view('livewire.dashboard.bookings.bookings', [
            'bookings'  => $bookings,
            'metrics'   => $metrics,
            'companies' => $companies,
        ])->with('title', 'Monitoramento de Reservas');
    }
}