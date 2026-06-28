<?php

namespace App\Services\Wallet;

use App\Enums\WalletStatusEnum;
use App\Models\Company;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class FinancialDashboardService
{
    public function company(Company $company): array
    {
        $transactions = WalletTransaction::query()
            ->where('company_id', $company->id);

        $available = (clone $transactions)
            ->where('status', WalletStatusEnum::Available)
            ->sum('net_amount');

        $pending = (clone $transactions)
            ->where('status', WalletStatusEnum::Pending)
            ->sum('net_amount');

        $sold = (clone $transactions)
            ->sum('gross_amount');

        $commission = (clone $transactions)
            ->sum('fee_amount');

        $withdrawn = abs(
            (clone $transactions)
                ->where('type', 'withdrawal')
                ->sum('net_amount')
        );

        $nextRelease = WalletTransaction::query()
            ->where('company_id', $company->id)
            ->where('status', WalletStatusEnum::Pending)
            ->orderBy('available_at')
            ->first();

        return [
            'available' => $available,
            'pending' => $pending,
            'sold' => $sold,
            'commission' => $commission,
            'withdrawn' => $withdrawn,
            'next_release' => $nextRelease,
        ];
    }
}