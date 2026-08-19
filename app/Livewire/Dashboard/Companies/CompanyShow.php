<?php

namespace App\Livewire\Dashboard\Companies;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Company;
use Livewire\Component;

class CompanyShow extends Component
{
    public Company $company;

    public array $revenueChart = ['labels' => [], 'values' => []];

    public array $bookingsStatusChart = ['labels' => [], 'values' => []];

    public array $tourTypeChart = ['labels' => [], 'values' => []];

    public function mount(Company $company): void
    {
        $this->company = $company->load([
            'vessels',
            'tours.vessel',
            'customers',
            'bookings.tour',
        ]);

        $this->loadCharts();
    }

    protected function loadCharts(): void
    {
        $paid = \App\Models\Booking::where('company_id', $this->company->id)
            ->where('payment_status', PaymentStatusEnum::PAID);

        $monthly = (clone $paid)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $this->revenueChart = [
            'labels' => $monthly->pluck('month')
                ->map(fn ($m) => \Carbon\Carbon::createFromFormat('Y-m', $m)->translatedFormat('M/Y'))
                ->values()
                ->all(),
            'values' => $monthly->pluck('total')
                ->map(fn ($v) => (float) $v)
                ->values()
                ->all(),
        ];

        $statuses = $this->company->bookings
            ->groupBy(fn ($b) => $b->status->value)
            ->map->count();

        $statusLabels = [
            BookingStatusEnum::PENDING->value   => 'Aguardando',
            BookingStatusEnum::CONFIRMED->value => 'Confirmadas',
            BookingStatusEnum::CANCELLED->value => 'Canceladas',
            BookingStatusEnum::COMPLETED->value => 'Concluídas',
            BookingStatusEnum::NO_SHOW->value   => 'Não compareceram',
        ];

        $this->bookingsStatusChart = [
            'labels' => $statuses->keys()->map(fn ($k) => $statusLabels[$k] ?? $k)->values()->all(),
            'values' => $statuses->values()->all(),
        ];

        $types = $this->company->tours
            ->groupBy(fn ($t) => $t->tour_type?->label() ?? 'Não informado')
            ->map->count();

        $this->tourTypeChart = [
            'labels' => $types->keys()->values()->all(),
            'values' => $types->values()->all(),
        ];
    }

    public function render()
    {
        $company = $this->company;

        $metrics = [
            'vessels'       => $company->vessels->count(),
            'tours'         => $company->tours->count(),
            'activeTours'   => $company->tours->where('active', true)->count(),
            'customers'     => $company->customers->count(),
            'bookings'      => $company->bookings->count(),
            'paidBookings'  => $company->bookings->where('payment_status', PaymentStatusEnum::PAID)->count(),
            'revenue'       => $company->bookings->where('payment_status', PaymentStatusEnum::PAID)->sum('total'),
            'commission'    => $company->bookings->where('payment_status', PaymentStatusEnum::PAID)->sum('commission_amount'),
            'available'     => $company->available_balance,
            'pending'       => $company->pending_balance,
            'withdrawn'     => $company->total_withdrawn,
        ];

        $recentBookings = $company->bookings
            ->sortByDesc('created_at')
            ->take(10)
            ->values();

        return view('livewire.dashboard.companies.company-show', [
            'company'        => $company,
            'metrics'        => $metrics,
            'recentBookings' => $recentBookings,
        ])->with('title', 'Perfil de ' . $company->alias_name);
    }
}