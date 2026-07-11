<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Booking;
use App\Models\TourDate;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use App\Enums\PaymentStatusEnum;
use App\Enums\BookingStatusEnum;
use App\Enums\WalletStatusEnum;
use App\Enums\WithdrawalStatusEnum;
use Illuminate\Support\Carbon;

class CompanyReportService
{
    protected Carbon $start;
    protected Carbon $end;

    public function generate(Company $company, string $period): array
    {
        [$this->start, $this->end] = $this->resolvePeriod($period);

        return [
            'period'      => $period,
            'period_label'=> $this->periodLabel($period),
            'start'       => $this->start,
            'end'         => $this->end,
            'company'     => $company,
            'sales'       => $this->sales($company),
            'bookings'    => $this->bookings($company),
            'tours'       => $this->tourPerformance($company),
            'financial'   => $this->financial($company),
            'vessels'     => $this->vesselUsage($company),
            'clients'     => $this->clients($company),
        ];
    }

    protected function resolvePeriod(string $period): array
    {
        return match ($period) {
            'today' => [now()->startOfDay(), now()->endOfDay()],
            'year'  => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->startOfMonth(), now()->endOfMonth()], // 'month'
        };
    }

    protected function periodLabel(string $period): string
    {
        return match ($period) {
            'today' => 'Hoje (' . now()->format('d/m/Y') . ')',
            'year'  => 'Ano de ' . now()->year,
            default => ucfirst(now()->translatedFormat('F \\d\\e Y')),
        };
    }

    protected function baseBookingsQuery(Company $company)
    {
        return Booking::query()
            ->whereHas('tour', fn($q) => $q->where('company_id', $company->id))
            ->whereBetween('created_at', [$this->start, $this->end]);
    }

    protected function sales(Company $company): array
    {
        $paid = (clone $this->baseBookingsQuery($company))
            ->where('payment_status', PaymentStatusEnum::PAID);

        return [
            'total_revenue'   => (float) $paid->sum('total'),
            'total_paid_count'=> (clone $paid)->count(),
            'average_ticket'  => (float) ((clone $paid)->avg('total') ?? 0),
        ];
    }

    protected function bookings(Company $company): array
    {
        $all = $this->baseBookingsQuery($company)->get();

        $byStatus = $all->groupBy(fn($b) => $b->status->value)->map->count();
        $byPayment = $all->groupBy(fn($b) => $b->payment_status->value)->map->count();

        $topTours = $all->where('payment_status', PaymentStatusEnum::PAID)
            ->groupBy(fn($b) => $b->tour?->title ?? 'Sem título')
            ->map->count()
            ->sortDesc()
            ->take(5);

        return [
            'total'       => $all->count(),
            'by_status'   => $byStatus,
            'by_payment'  => $byPayment,
            'top_tours'   => $topTours,
        ];
    }

    protected function tourPerformance(Company $company): array
    {
        return $company->tours()
            ->withCount(['bookings as paid_bookings_count' => function ($q) {
                $q->where('payment_status', PaymentStatusEnum::PAID)
                  ->whereBetween('bookings.created_at', [$this->start, $this->end]);
            }])
            ->withSum(['bookings as revenue' => function ($q) {
                $q->where('payment_status', PaymentStatusEnum::PAID)
                  ->whereBetween('bookings.created_at', [$this->start, $this->end]);
            }], 'total')
            ->get()
            ->map(function ($tour) {
                $dates = TourDate::where('tour_id', $tour->id)
                    ->whereBetween('date', [$this->start, $this->end])
                    ->get();

                $totalSlots = $dates->sum('available_slots') + $tour->paid_bookings_count; // aproximação de capacidade total
                $occupancy = $totalSlots > 0
                    ? round(($tour->paid_bookings_count / max($totalSlots, 1)) * 100, 1)
                    : 0;

                return [
                    'title'         => $tour->title,
                    'bookings'      => $tour->paid_bookings_count,
                    'revenue'       => (float) ($tour->revenue ?? 0),
                    'average_ticket'=> $tour->paid_bookings_count > 0 ? (float) ($tour->revenue / $tour->paid_bookings_count) : 0,
                    'occupancy'     => $occupancy,
                ];
            })
            ->sortByDesc('revenue')
            ->values()
            ->toArray();
    }

    protected function financial(Company $company): array
    {
        $commission = WalletTransaction::where('company_id', $company->id)
            ->whereBetween('created_at', [$this->start, $this->end])
            ->sum('fee_amount');

        $withdrawn = Withdrawal::where('company_id', $company->id)
            ->where('status', WithdrawalStatusEnum::PAID)
            ->whereBetween('paid_at', [$this->start, $this->end])
            ->sum('net_amount');

        $pendingWithdrawals = Withdrawal::where('company_id', $company->id)
            ->whereIn('status', [WithdrawalStatusEnum::REQUESTED, WithdrawalStatusEnum::APPROVED])
            ->sum('net_amount');

        return [
            'available_balance'   => (float) $company->available_balance,
            'pending_balance'     => (float) $company->pending_balance,
            'commission_period'   => (float) abs($commission),
            'withdrawn_period'    => (float) $withdrawn,
            'pending_withdrawals' => (float) $pendingWithdrawals,
            'cancelled_balance'   => (float) $company->cancelled_balance,
        ];
    }

    protected function vesselUsage(Company $company): array
    {
        // ⚠️ Assume relação Tour->vessel(). Ajustar se o nome/estrutura for diferente.
        if (!method_exists(\App\Models\Tour::class, 'vessel')) {
            return [];
        }

        return $company->vessels()
            ->withCount(['tours as bookings_count' => function ($q) {
                $q->whereHas('bookings', function ($bq) {
                    $bq->where('payment_status', PaymentStatusEnum::PAID)
                       ->whereBetween('created_at', [$this->start, $this->end]);
                });
            }])
            ->get()
            ->map(fn($vessel) => [
                'name'     => $vessel->name,
                'bookings' => $vessel->bookings_count,
                'active'   => $vessel->active,
            ])
            ->sortByDesc('bookings')
            ->values()
            ->toArray();
    }

    protected function clients(Company $company): array
    {
        $periodBookings = $this->baseBookingsQuery($company)
            ->where('payment_status', PaymentStatusEnum::PAID)
            ->get()
            ->unique('customer_email');

        $previousCustomerEmails = Booking::query()
            ->whereHas('tour', fn($q) => $q->where('company_id', $company->id))
            ->where('payment_status', PaymentStatusEnum::PAID)
            ->where('created_at', '<', $this->start)
            ->pluck('customer_email')
            ->unique();

        $new = $periodBookings->reject(fn($b) => $previousCustomerEmails->contains($b->customer_email));
        $returning = $periodBookings->filter(fn($b) => $previousCustomerEmails->contains($b->customer_email));

        return [
            'total'     => $periodBookings->count(),
            'new'       => $new->count(),
            'returning' => $returning->count(),
        ];
    }
}