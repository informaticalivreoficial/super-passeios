<?php

namespace App\Services\Wallet;

use App\Enums\WalletStatusEnum;
use App\Enums\WalletTypeEnum;
use App\Models\Company;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WithdrawalService
{
    public function request(
        Company $company,
        float $amount
    ): Withdrawal {

        $available = $company->available_balance;

        if ($amount > $available) {
            throw new \Exception('Saldo insuficiente.');
        }

        return DB::transaction(function () use ($company, $amount) {

            return Withdrawal::create([
                'uuid' => Str::uuid(),
                'company_id' => $company->id,
                'amount' => $amount,
                'status' => 'requested',
            ]);

        });
    }

    public function approve(Withdrawal $withdrawal): void
    {
        $withdrawal->update([
            'status' => 'approved',
        ]);
    }

    public function pay(Withdrawal $withdrawal): void
    {
        DB::transaction(function () use ($withdrawal) {

            $withdrawal->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            WalletTransaction::create([
                'uuid' => Str::uuid(),
                'company_id' => $withdrawal->company_id,
                'type' => WalletTypeEnum::Withdrawal,
                'status' => WalletStatusEnum::Paid,
                'description' => "Saque #{$withdrawal->id}",
                'gross_amount' => 0,
                'fee_percentage' => 0,
                'fee_amount' => 0,
                'net_amount' => -$withdrawal->amount,
                'paid_at' => now(),
            ]);

        });
    }
}