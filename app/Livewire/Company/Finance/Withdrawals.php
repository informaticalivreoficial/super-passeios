<?php

namespace App\Livewire\Company\Finance;

use Livewire\Component;
use App\Models\Withdrawal;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\BankAccount;
use Livewire\Attributes\Layout;

class Withdrawals extends Component
{
    use WithPagination;

    public $amount;
    public $notes;
    public $selectedAccountId; // Conta bancária selecionada
    public $successMsg;

    protected $rules = [
        'amount' => 'required|numeric|min:50',
        'selectedAccountId' => 'required|exists:bank_accounts,id',
        'notes'  => 'nullable|string|max:255',
    ];

    public function mount()
    {
        // Seleciona automaticamente a conta padrão da empresa
        $defaultAccount = BankAccount::where('company_id', Auth::user()->company_id)
            ->where('is_default', true)
            ->first();

        if ($defaultAccount) {
            $this->selectedAccountId = $defaultAccount->id;
        }
    }

    public function getBalanceProperty()
    {
        $companyId = Auth::user()->company_id;
        $credits = WalletTransaction::where('company_id', $companyId)->where('type', 'credit')->sum('net_amount');
        $withdrawals = Withdrawal::where('company_id', $companyId)->whereIn('status', ['requested', 'approved', 'paid'])->sum('amount');
        return $credits - $withdrawals;
    }

    public function requestWithdrawal()
    {
        $this->validate();

        if ($this->amount > $this->balance) {
            $this->addError('amount', 'Saldo insuficiente.');
            return;
        }

        try {
            DB::transaction(function () {
                $companyId = Auth::user()->company_id;
                $account = BankAccount::find($this->selectedAccountId);

                // Criar o saque vinculando os dados da conta escolhida nas notas 
                // (ou em uma coluna bank_account_id se você a criar)
                $withdrawal = Withdrawal::create([
                    'company_id' => $companyId,
                    'amount'     => $this->amount,
                    'status'     => 'requested',
                    'notes'      => "Conta: {$account->label}. " . ($this->notes ?? ''),
                ]);

                WalletTransaction::create([
                    'company_id'   => $companyId,
                    'uuid'         => (string) \Illuminate\Support\Str::uuid(),
                    'type'         => 'debit',
                    'status'       => 'pending',
                    'description'  => "Saque solicitado para: {$account->label}",
                    'gross_amount' => $this->amount,
                    'net_amount'   => $this->amount,
                    'available_at' => now(),
                ]);
            });

            $this->reset(['amount', 'notes']);
            $this->successMsg = 'Saque solicitado com sucesso!';
            
        } catch (\Exception $e) {
            $this->addError('amount', 'Erro: ' . $e->getMessage());
        }
    }

    #[Layout('components.layouts.company', ['title' => 'Gerenciar Saques'])]
    public function render()
    {
        $companyId = Auth::user()->company_id;

        return view('livewire.company.finance.withdrawals', [
            'withdrawals' => Withdrawal::where('company_id', $companyId)->orderBy('created_at', 'desc')->paginate(10),
            'bankAccounts' => BankAccount::where('company_id', $companyId)->get(),
            'balance' => $this->balance,
        ]);
    }
}
