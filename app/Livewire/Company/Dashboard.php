<?php

namespace App\Livewire\Company;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\Wallet\FinancialDashboardService;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class Dashboard extends Component
{
    private function getCompany(): ?Company
    {
        return Auth::guard('customer')->user()->company;
    }

    #[Layout('components.layouts.company', ['title' => 'Painel de Controle'])]
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
        ]);
    }
}
