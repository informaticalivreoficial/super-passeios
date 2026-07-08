<?php

namespace App\Livewire\Company\Finance;

use App\Enums\WalletStatusEnum;
use App\Enums\WalletTypeEnum;
use App\Models\BankAccount;
use App\Models\Withdrawal;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use App\Services\Wallet\WithdrawalService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Withdrawals extends Component
{
    use WithPagination;

    public float $amount = 0;
    public $notes;
    public $selectedAccountId;
    public $successMsg;

    protected $rules = [
        'amount'            => 'required|numeric|min:10',
        'selectedAccountId' => 'required|exists:bank_accounts,id',
        'notes'             => 'nullable|string|max:255',
    ];

    protected $messages = [
        'amount.required' => 'Informe o valor do saque.',
        'amount.min' => 'O valor mínimo para saque é R$ 10,00.',
        'selectedAccountId.required' => 'Selecione uma conta bancária.',
    ];

    private function customer()
    {
        return Auth::guard('customer')->user();
    }

    public function mount(): void
    {
        $default = BankAccount::where('company_id', $this->customer()->company_id)
            ->where('is_default', true)
            ->first();

        if ($default) {
            $this->selectedAccountId = $default->id;
        }
    }

    public function getBalanceProperty(): float
    {
        return (float) $this->customer()->company->available_balance;
    }

    public function requestWithdrawal(WithdrawalService $service): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->validate();

        if ($this->amount > $this->balance) {
            $this->addError('amount', 'Saldo insuficiente.');
            return;
        }

        try {
            $company = $this->customer()->company;

            $account = $company->bankAccounts()
                ->findOrFail($this->selectedAccountId);

            $service->request(
                $company,
                $account,
                $this->amount
            );

            $this->reset(['amount', 'notes']);
            $this->mount();

            $this->successMsg = 'Saque solicitado com sucesso!';

        } catch (\Exception $e) {
            $this->addError('amount', $e->getMessage());
        }
    }

    #[Layout('components.layouts.company', ['title' => 'Saques', 'bracrhumb' => 'Solicite transferências do seu saldo disponível.'])]
    public function render()
    {
        $companyId = $this->customer()->company_id;

        return view('livewire.company.finance.withdrawals', [
            'withdrawals'  => Withdrawal::where('company_id', $companyId)
                ->latest()
                ->paginate(10),
            'bankAccounts' => BankAccount::where('company_id', $companyId)
                ->orderByDesc('is_default')
                ->get(),
            'balance' => $this->balance, // ← adiciona aqui
        ]);
    }
}