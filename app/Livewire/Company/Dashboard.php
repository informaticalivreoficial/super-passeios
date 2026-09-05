<?php

namespace App\Livewire\Company;

use App\Enums\PaymentStatusEnum;
use App\Enums\TourDateStatusEnum;
use App\Models\Booking;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\Wallet\FinancialDashboardService;
use App\Services\OperatorDocumentService;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\TourDate;

class Dashboard extends Component
{
    private function getCompany(): ?Company
    {
        return Auth::guard('customer')->user()->company;
    }

    private function getUpcomingBookings(Company $company)
    {
        return Booking::query()
            ->whereHas('tour', fn($q) => $q->where('company_id', $company->id))
            ->whereHas('tourDate', fn($q) => $q->whereBetween('date', [today(), today()->addDays(7)]))
            ->where('payment_status', PaymentStatusEnum::PAID)
            ->with(['tour', 'tourDate'])
            ->get()
            ->sortBy(fn($booking) => $booking->tourDate->date->format('Y-m-d') . $booking->tourDate->start_time)
            ->take(6);
    }

    private function getRevenueChartData(Company $company): array
    {
        $bookings = Booking::query()
            ->whereHas('tour', fn($q) => $q->where('company_id', $company->id))
            ->where('payment_status', PaymentStatusEnum::PAID)
            ->where('paid_at', '>=', now()->subDays(29)->startOfDay())
            ->selectRaw('DATE(paid_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $values = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            $values[] = (float) ($bookings[$date]->total ?? 0);
        }

        return ['labels' => $labels, 'values' => $values];
    }

    private function getLowAvailabilityTourDates(Company $company)
    {
        return TourDate::query()
            ->whereHas('tour', fn($q) => $q->where('company_id', $company->id))
            ->where('active', true)
            ->where('date', '>=', today())
            ->where('status', TourDateStatusEnum::OPEN)
            ->where('available_slots', '>', 0)
            ->where('available_slots', '<=', 3)
            ->with('tour')
            ->orderBy('date')
            ->limit(6)
            ->get();
    }

    #[Layout('components.layouts.company', ['title' => 'Painel de Controle', 'bracrhumb' => 'Painel de Controle'])]
    public function render(FinancialDashboardService $service)
    {
        $company = $this->getCompany();

        if (!$company) {
            return view('livewire.company.dashboard', [
                'hasCompany' => false,
                'data'       => null,
                'company'    => null,
            ]);
        }

        $data = $service->company($company);

        return view('livewire.company.dashboard', [
            'hasCompany' => true,
            'data'       => $data,
            'company'    => $company,
            'upcomingBookings'    => $this->getUpcomingBookings($company),
            'revenueChartData'    => $this->getRevenueChartData($company),
            'lowAvailabilityDates'=> $this->getLowAvailabilityTourDates($company),
        ]);
    }
}
