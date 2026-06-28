<?php

namespace App\Services\Wallet;

use App\Models\Company;

class CommissionService
{
    public function calculate(Company $company, float $gross): array
    {
        $percentage = $company->commission_rate;
        $fee = round($gross * ($percentage / 100), 2);
        $net = round($gross - $fee, 2);

        return [
            'gross_amount'    => $gross,
            'fee_percentage'  => $percentage,
            'fee_amount'      => $fee,
            'net_amount'      => $net,
        ];
    }
}