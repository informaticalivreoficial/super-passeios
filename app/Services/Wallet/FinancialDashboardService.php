<?php

namespace App\Services\Wallet;

use App\Enums\WalletStatusEnum;
use App\Enums\WalletTypeEnum;
use App\Models\Company;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class FinancialDashboardService
{
    public function company(Company $company): array
    {
        $transactions = WalletTransaction::query()
            ->where('company_id', $company->id);

        return [
            'available_balance'  => $company->available_balance,
            'pending_balance'    => $company->pending_balance,
            'total_sales'        => $company->total_sales,
            'total_commission'   => $company->total_commission,
            'total_withdrawn'    => $company->total_withdrawn,
            'cancelled_balance'  => $company->cancelled_balance, // 👈 novo

            'next_release' => WalletTransaction::query()
                    ->where('company_id', $company->id)
                    ->where('status', WalletStatusEnum::Pending)
                    ->orderBy('available_at')
                    ->first(),

            'recent_transactions' => WalletTransaction::query()
                    ->where('company_id', $company->id)
                    ->latest()
                    ->limit(10)
                    ->get(),
        ];
    }
}