<?php

namespace App\Livewire\Company\Finance;

use App\Enums\WalletStatusEnum;
use App\Enums\WalletTypeEnum;
use App\Models\BankAccount;
use App\Models\Withdrawal;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Withdrawals extends Component
{
    use WithPagination;

    public $amount;
    public $notes;
    public $selectedAccountId;
    public $successMsg;

    protected $rules = [
        'amount'            => 'required|numeric|min:50',
        'selectedAccountId' => 'required|exists:bank_accounts,id',
        'notes'             => 'nullable|string|max:255',
    ];

    protected $messages = [
        'amount.required'             => 'Informe o valor do saque.',
        'amount.min'                  => 'Valor mínimo para saque é R$ 2,00.',
        'selectedAccountId.required'  => 'Selecione uma conta bancária.',
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
        $companyId = $this->customer()->company_id;

        $credits = WalletTransaction::where('company_id', $companyId)
            ->where('status', WalletStatusEnum::Available)
            ->sum('net_amount');

        $debits = Withdrawal::where('company_id', $companyId)
            ->whereIn('status', ['requested', 'approved'])
            ->sum('amount');

        return max(0, $credits - $debits);
    }

    public function requestWithdrawal(): void
    {
        $this->validate();

        if ($this->amount > $this->balance) {
            $this->addError('amount', 'Saldo insuficiente.');
            return;
        }

        try {
            DB::transaction(function () {
                $companyId = $this->customer()->company_id;
                $account   = BankAccount::findOrFail($this->selectedAccountId);

                Withdrawal::create([
                    'company_id'      => $companyId,
                    'bank_account_id' => $account->id,
                    'amount'          => $this->amount,
                    'status'          => 'requested',
                    'notes'           => $this->notes,
                ]);

                WalletTransaction::create([
                    'uuid'           => (string) Str::uuid(),
                    'company_id'     => $companyId,
                    'type'           => WalletTypeEnum::Withdrawal,
                    'status'         => WalletStatusEnum::Pending,
                    'description'    => "Saque solicitado · {$account->label}",
                    'gross_amount'   => $this->amount,
                    'fee_percentage' => 0,
                    'fee_amount'     => 0,
                    'net_amount'     => -$this->amount,
                    'available_at'   => now(),
                ]);
            });

            $this->reset(['amount', 'notes']);
            $this->successMsg = 'Saque solicitado com sucesso!';

        } catch (\Exception $e) {
            $this->addError('amount', 'Erro: ' . $e->getMessage());
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