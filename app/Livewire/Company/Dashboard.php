<?php

namespace App\Livewire\Company;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\Wallet\FinancialDashboardService;

class Dashboard extends Component
{
    public array $wallet = [];

    public function mount(FinancialDashboardService $service)
    {
        $company = auth('customer')->user()->company;

        $this->wallet = $service->company($company);
        
    }

    #[Layout('components.layouts.company', ['title' => 'Painel de Controle'])]
    public function render()
    {
        return view('livewire.company.dashboard');
    }
}
