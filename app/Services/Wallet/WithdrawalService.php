<?php

namespace App\Services\Wallet;

use App\Enums\WalletStatusEnum;
use App\Enums\WalletTypeEnum;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WithdrawalService
{
     /**
     * Solicita um saque.
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

        if ($amount > $company->available_balance) {
            throw new \Exception('Saldo insuficiente.');
        }

        $fee = 0;
        $netAmount = $amount - $fee;

        return DB::transaction(function () use (
            $company,
            $bankAccount,
            $amount,
            $fee,
            $netAmount
        ) {

            return Withdrawal::create([
                'uuid' => Str::uuid(),
                'company_id' => $company->id,
                'bank_account_id' => $bankAccount->id,
                'amount' => $amount,
                'fee' => $fee,
                'net_amount' => $netAmount,
                'status' => 'requested',
                'requested_at' => now(),
            ]);

        });
    }

    /**
     * Aprova um saque.
     */
    public function approve(Withdrawal $withdrawal): void
    {
        if ($withdrawal->status !== 'requested') {
            throw new \Exception('Este saque não pode ser aprovado.');
        }

        $withdrawal->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
    }

    /**
     * Recusa um saque.
     */
    public function reject(
        Withdrawal $withdrawal,
        ?string $reason = null
    ): void {

        if ($withdrawal->status !== 'requested') {
            throw new \Exception('Este saque não pode ser recusado.');
        }

        $withdrawal->update([
            'status' => 'rejected',
            'notes' => $reason,
        ]);
    }

    /**
     * Marca um saque como pago.
     */
    public function pay(
        Withdrawal $withdrawal,
        ?string $paymentReference = null
    ): void {

        if ($withdrawal->status !== 'approved') {
            throw new \Exception('O saque precisa estar aprovado.');
        }

        if ($withdrawal->paid_at) {
            throw new \Exception('Este saque já foi pago.');
        }

        DB::transaction(function () use (
            $withdrawal,
            $paymentReference
        ) {

            $withdrawal->company()->decrement(
                'available_balance',
                $withdrawal->net_amount
            );

            $withdrawal->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_reference' => $paymentReference,
            ]);

            WalletTransaction::create([
                'uuid' => Str::uuid(),
                'company_id' => $withdrawal->company_id,
                'type' => WalletTypeEnum::Withdrawal,
                'status' => WalletStatusEnum::Paid,
                'description' => "Saque #{$withdrawal->id}",

                'gross_amount' => -$withdrawal->amount,
                'fee_percentage' => 0,
                'fee_amount' => -$withdrawal->fee,
                'net_amount' => -$withdrawal->net_amount,

                'available_at' => now(),
                'paid_at' => now(),
            ]);
        });
    }

    /**
     * Cancela um saque.
     */
    public function cancel(Withdrawal $withdrawal): void
    {
        if ($withdrawal->status === 'paid') {
            throw new \Exception('Não é possível cancelar um saque já pago.');
        }

        $withdrawal->update([
            'status' => 'canceled',
        ]);
    }
}