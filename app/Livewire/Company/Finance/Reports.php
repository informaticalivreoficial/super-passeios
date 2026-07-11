<?php

namespace App\Livewire\Company\Finance;

use App\Models\Company;
use App\Services\CompanyReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Reports extends Component
{
    public string $period = 'month';

    private function getCompany(): ?Company
    {
        return Auth::guard('customer')->user()->company;
    }

    public function setPeriod(string $period)
    {
        $this->period = $period;
    }

    public function exportPdf(CompanyReportService $service)
    {
        $company = $this->getCompany();
        $data = $service->generate($company, $this->period);

        $pdf = Pdf::loadView('pdf.company.reports-pdf', $data)
            ->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'relatorio-' . $this->period . '-' . now()->format('Y-m-d') . '.pdf'
        );
    }

    #[Layout('components.layouts.company', ['title' => 'Relatórios', 'bracrhumb' => 'Relatórios'])]
    public function render(CompanyReportService $service)
    {
        $company = $this->getCompany();

        if (!$company) {
            return view('livewire.company.finance.reports', ['hasCompany' => false]);
        }

        $data = $service->generate($company, $this->period);

        return view('livewire.company.finance.reports', array_merge($data, [
            'hasCompany' => true,
        ]));
    }
}
