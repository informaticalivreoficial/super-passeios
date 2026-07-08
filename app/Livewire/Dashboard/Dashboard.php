<?php

namespace App\Livewire\Dashboard;

use App\Models\Company;
use App\Models\Post;
use App\Models\Tour;
use App\Models\TourDate;
use App\Models\Booking;
use App\Models\WalletTransaction;
use App\Enums\WalletStatusEnum;
use Livewire\Component;
use App\Traits\WithToastr;

class Dashboard extends Component
{
    use WithToastr;

    public $topcompanies = [];

    // Conteúdo
    public $noticiasCount;
    public $noticiasYearCount;
    public $articlesCount;
    public $articlesYearCount;

    // Tours
    public $toursActiveCount;
    public $toursInactiveCount;
    public $toursWithoutDatesCount;

    // Operadoras
    public $companyCount;
    public $companyYearCount;
    public $companiesWithNoToursCount;

    // Reservas
    public $bookingsTodayCount;
    public $bookingsThisMonthCount;
    public $bookingsPendingCount;
    public $bookingsCancelledThisMonthCount;
    public $averageTicket;
    public $conversionRate;

    // Financeiro
    public $totalPaidGross;
    public $totalPaidThisMonth;
    public $commissionEarned;
    public $pendingPayout;
    public $availableForWithdraw;
    public $totalPaidOut;

    // Gráficos
    protected $revenueChartData;
    protected $bookingsStatusChartData;

    public function mount()
    {
        $this->authorize('viewAny', Company::class);

        $this->loadContentMetrics();
        $this->loadTourMetrics();
        $this->loadCompanyMetrics();
        $this->loadBookingMetrics();
        $this->loadFinancialMetrics();
        $this->loadChartData();
    }

    protected function loadContentMetrics()
    {
        $this->noticiasCount = Post::where('type', 'noticia')->count();
        $this->noticiasYearCount = Post::where('type', 'noticia')
            ->whereYear('created_at', now()->year)->count();

        $this->articlesCount = Post::where('type', 'artigo')->count();
        $this->articlesYearCount = Post::where('type', 'artigo')
            ->whereYear('created_at', now()->year)->count();
    }

    protected function loadTourMetrics()
    {
        $this->toursActiveCount = cache()->remember('dashboard.tours_active', now()->addMinutes(10), function () {
            return Tour::where('active', true)->count();
        });

        $this->toursInactiveCount = cache()->remember('dashboard.tours_inactive', now()->addMinutes(10), function () {
            return Tour::where('active', false)->count();
        });

        $this->toursWithoutDatesCount = cache()->remember('dashboard.tours_without_dates', now()->addMinutes(10), function () {
            return Tour::doesntHave('tourDates')->count();
        });
    }

    protected function loadCompanyMetrics()
    {
        $this->companyCount = Company::count();
        $this->companyYearCount = Company::whereYear('created_at', now()->year)->count();

        $this->companiesWithNoToursCount = cache()->remember('dashboard.companies_no_tours', now()->addMinutes(10), function () {
            return Company::doesntHave('tours')->count();
        });
    }

    protected function loadBookingMetrics()
    {
        $this->bookingsTodayCount = Booking::whereDate('created_at', today())->count();

        $this->bookingsThisMonthCount = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->count();

        $this->bookingsPendingCount = Booking::where('payment_status', 'pending')->count();

        $this->bookingsCancelledThisMonthCount = Booking::where('payment_status', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->count();

        $this->averageTicket = cache()->remember('dashboard.average_ticket', now()->addMinutes(10), function () {
            return Booking::where('payment_status', 'paid')->avg('total') ?? 0;
        });

        $totalBookingsThisMonth = $this->bookingsThisMonthCount;
        $paidBookingsThisMonth = Booking::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->count();

        $this->conversionRate = $totalBookingsThisMonth > 0
            ? round(($paidBookingsThisMonth / $totalBookingsThisMonth) * 100, 1)
            : 0;
    }

    protected function loadFinancialMetrics()
    {
        $this->totalPaidGross = cache()->remember('dashboard.total_paid_gross', now()->addMinutes(10), function () {
            return Booking::where('payment_status', 'paid')->sum('total');
        });

        $this->totalPaidThisMonth = Booking::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $this->commissionEarned = cache()->remember('dashboard.commission_earned', now()->addMinutes(10), function () {
            return Booking::where('payment_status', 'paid')->sum('commission_amount');
        });

        $this->pendingPayout = cache()->remember('dashboard.pending_payout', now()->addMinutes(5), function () {
            return WalletTransaction::where('status', WalletStatusEnum::Pending)->sum('gross_amount');
        });

        $this->availableForWithdraw = cache()->remember('dashboard.available_payout', now()->addMinutes(5), function () {
            return WalletTransaction::where('status', WalletStatusEnum::Available)->sum('gross_amount');
        });

        $this->totalPaidOut = cache()->remember('dashboard.total_paid_out', now()->addMinutes(10), function () {
            return WalletTransaction::where('status', WalletStatusEnum::Paid)->sum('gross_amount');
        });
    }

    protected function loadChartData()
    {
        $revenue = Booking::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $values = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            $values[] = (float) ($revenue[$date]->total ?? 0);
        }

        $this->revenueChartData = [
            'labels' => $labels,
            'values' => $values,
        ];

        $this->bookingsStatusChartData = [
            'labels' => ['Pagas', 'Pendentes', 'Canceladas'],
            'values' => [
                Booking::where('payment_status', 'paid')->whereMonth('created_at', now()->month)->count(),
                $this->bookingsPendingCount,
                $this->bookingsCancelledThisMonthCount,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard', [
            'title' => 'Painel de Controle',
            'revenueChartData' => $this->revenueChartData,
            'bookingsStatusChartData' => $this->bookingsStatusChartData,
        ]);
    }
}