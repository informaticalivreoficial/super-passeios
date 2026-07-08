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
    public ?int $bankAccountId = null;

    public function openWithdrawalModal()
    {
        $this->bankAccountId = $this->getCompany()
            ->bankAccounts()
            ->where('is_default', true)
            ->value('id');

        $this->showWithdrawalModal = true;
    }

    public function requestWithdrawal(WithdrawalService $service): void
    {
        $this->validate([
            'withdrawalAmount' => ['required', 'numeric', 'min:10'],
            'bankAccountId' => ['required', 'exists:bank_accounts,id'],
        ], [
            'withdrawalAmount.min' => 'Valor mínimo para saque é R$ 10,00.',
            'bankAccountId.required' => 'Selecione uma conta bancária.',
        ]);

        try {
            $company = $this->getCompany();

            $bankAccount = $company->bankAccounts()->findOrFail($this->bankAccountId);

            if (!$bankAccount) {
                throw new \Exception('Cadastre uma conta bancária antes de solicitar um saque.');
            }

            $service->request(
                $company,
                $bankAccount,
                $this->withdrawalAmount
            );           

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
