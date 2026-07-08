<?php

namespace App\Services\Wallet;

use App\Enums\WalletStatusEnum;
use App\Enums\WalletTypeEnum;
use App\Enums\WithdrawalStatusEnum;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalRequestedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class WithdrawalService
{
    /**
     * Solicita um saque. Debita o saldo imediatamente (reserva os fundos).
     */
    public function request(
        Company $company,
        BankAccount $bankAccount,
        float $amount
    ): Withdrawal {

        if ($amount <= 0) {
            throw new \Exception('Valor inválido.');
        }

        if ($bankAccount->company_id !== $company->id) {
            throw new \Exception('Conta bancária inválida.');
        }

        return DB::transaction(function () use ($company, $bankAccount, $amount) {

            // Lock para evitar condição de corrida em saques simultâneos
            $company = Company::where('id', $company->id)->lockForUpdate()->first();

            if ($amount > $company->available_balance) {
                throw new \Exception('Saldo insuficiente.');
            }

            $fee = 0;
            $netAmount = $amount - $fee;

            $withdrawal = Withdrawal::create([
                'uuid' => Str::uuid(),
                'company_id' => $company->id,
                'bank_account_id' => $bankAccount->id,
                'amount' => $amount,
                'fee' => $fee,
                'net_amount' => $netAmount,
                'status' => 'requested',
                'requested_at' => now(),
            ]);

            // Reserva/debita o saldo imediatamente, para evitar saque duplicado do mesmo valor
            WalletTransaction::create([
                'uuid' => Str::uuid(),
                'company_id' => $company->id,
                'withdrawal_id' => $withdrawal->id,
                'type' => WalletTypeEnum::Withdrawal,
                'status' => WalletStatusEnum::Available, // entra na soma, reduz o saldo já
                'description' => "Saque solicitado #{$withdrawal->id}",
                'gross_amount' => -$amount,
                'fee_percentage' => 0,
                'fee_amount' => -$fee,
                'net_amount' => -$netAmount,
                'available_at' => now(),
            ]);

            Notification::send(
                User::role(['admin', 'super-admin'])->get(),
                new WithdrawalRequestedNotification($withdrawal)
            );

            return $withdrawal;
        });
    }

    /**
     * Aprova um saque. Não mexe no saldo (já foi debitado no request).
     */
    public function approve(Withdrawal $withdrawal): void
    {
        if ($withdrawal->status !== WithdrawalStatusEnum::REQUESTED) {
            throw new \Exception('Este saque não pode ser aprovado.');
        }

        $withdrawal->update([
            'status' => WithdrawalStatusEnum::APPROVED,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
    }

    /**
     * Recusa um saque. Devolve o valor ao saldo disponível.
     */
    public function reject(Withdrawal $withdrawal, ?string $reason = null): void
    {
        if ($withdrawal->status !== WithdrawalStatusEnum::REQUESTED) {
            throw new \Exception('Este saque não pode ser recusado.');
        }

        DB::transaction(function () use ($withdrawal, $reason) {
            $withdrawal->update([
                'status' => WithdrawalStatusEnum::REJECTED,
                'notes' => $reason,
            ]);

            $this->refundReservedAmount($withdrawal, "Saque #{$withdrawal->id} recusado — saldo estornado");
        });
    }

    /**
     * Marca um saque como pago. Saldo já foi debitado no request(), só atualiza status.
     */
    public function pay(Withdrawal $withdrawal, ?string $paymentReference = null): void
    {
        if ($withdrawal->status !== WithdrawalStatusEnum::APPROVED) {
            throw new \Exception('O saque precisa estar aprovado.');
        }

        if ($withdrawal->paid_at) {
            throw new \Exception('Este saque já foi pago.');
        }

        $withdrawal->update([
            'status' => WithdrawalStatusEnum::PAID,
            'paid_at' => now(),
            'payment_reference' => $paymentReference,
        ]);
    }

    /**
     * Cancela um saque. Devolve o valor ao saldo disponível.
     */
    public function cancel(Withdrawal $withdrawal): void
    {
        if ($withdrawal->status === WithdrawalStatusEnum::PAID) {
            throw new \Exception('Não é possível cancelar um saque já pago.');
        }

        DB::transaction(function () use ($withdrawal) {
            $withdrawal->update(['status' => WithdrawalStatusEnum::CANCELLED]); // confirme o case: CANCELLED vs REJECTED

            $this->refundReservedAmount($withdrawal, "Saque #{$withdrawal->id} cancelado — saldo estornado");
        });
    }

    /**
     * Cria uma transação positiva devolvendo o valor reservado no request().
     */
    protected function refundReservedAmount(Withdrawal $withdrawal, string $description): void
    {
        WalletTransaction::create([
            'uuid' => Str::uuid(),
            'company_id' => $withdrawal->company_id,
            'withdrawal_id' => $withdrawal->id,
            'type' => WalletTypeEnum::Refund,
            'status' => WalletStatusEnum::Available,
            'description' => $description,
            'gross_amount' => $withdrawal->amount,
            'fee_percentage' => 0,
            'fee_amount' => $withdrawal->fee,
            'net_amount' => $withdrawal->net_amount,
            'available_at' => now(),
        ]);
    }
}