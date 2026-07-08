<?php

namespace App\Livewire\Company\Finance;

use App\Models\Company;
use App\Models\WalletTransaction;
use App\Services\Wallet\FinancialDashboardService;
use App\Services\Wallet\WithdrawalService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public float $withdrawalAmount = 0;
    public bool $showWithdrawalModal = false;

    public function requestWithdrawal(WithdrawalService $service): void
    {
        $this->validate([
            'withdrawalAmount' => 'required|numeric|min:10',
        ], [
            'withdrawalAmount.min' => 'Valor mínimo para saque é R$ 10,00.',
        ]);

        try {
            $company = $this->getCompany();
            $service->request($company, $this->withdrawalAmount);

            $this->showWithdrawalModal = false;
            $this->withdrawalAmount = 0;

            $this->dispatch('swal:success', [
                'title' => 'Solicitação enviada!',
                'text'  => 'Sua solicitação de saque foi enviada com sucesso.',
                'timer' => 2000,
                'showConfirmButton' => false,
            ]);

        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    private function getCompany(): Company
    {
        return Auth::guard('customer')->user()->company;
    }

    #[Layout('components.layouts.company', ['title' => 'Financeiro', 'bracrhumb' => 'Painel Financeiro'])]
    public function render(FinancialDashboardService $service)
    {
        $company = $this->getCompany();
        $data    = $service->company($company);

        $transactions = WalletTransaction::query()
            ->where('company_id', $company->id)
            ->latest()
            ->paginate(10);

        return view('livewire.company.finance.dashboard', [
            'data'         => $data,
            'transactions' => $transactions,
            'company'      => $company,
        ]);
    }
}
