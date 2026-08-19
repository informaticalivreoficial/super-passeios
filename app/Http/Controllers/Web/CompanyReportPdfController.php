<?php

namespace App\Http\Controllers\Web;

use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;

class CompanyReportPdfController extends Controller
{
    public function __invoke(Company $company)
    {
        $company->load([
            'vessels',
            'tours.vessel',
            'customers',
            'bookings.tour',
        ]);

        $paidBookings = $company->bookings->where('payment_status', PaymentStatusEnum::PAID);

        $metrics = [
            'vessels'      => $company->vessels->count(),
            'tours'        => $company->tours->count(),
            'activeTours'  => $company->tours->where('active', true)->count(),
            'customers'    => $company->customers->count(),
            'bookings'     => $company->bookings->count(),
            'paidBookings' => $paidBookings->count(),
            'revenue'      => $paidBookings->sum('total'),
            'commission'   => $paidBookings->sum('commission_amount'),
            'available'    => $company->available_balance,
            'pending'      => $company->pending_balance,
            'withdrawn'    => $company->total_withdrawn,
        ];

        $recentBookings = $company->bookings
            ->sortByDesc('created_at')
            ->take(10)
            ->values();

        $pdf = Pdf::loadView('pdf.company-report', [
            'company'        => $company,
            'metrics'        => $metrics,
            'recentBookings' => $recentBookings,
        ])->setPaper('a4', 'portrait');

        $filename = 'relatorio-empresa-'.strtolower(str_replace(' ', '-', $company->alias_name)).'.pdf';

        return $pdf->download($filename);
    }
}