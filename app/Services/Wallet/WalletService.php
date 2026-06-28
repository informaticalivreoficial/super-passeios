<?php

namespace App\Services\Wallet;

use App\Enums\WalletStatusEnum;
use App\Enums\WalletTypeEnum;
use App\Models\Booking;
use App\Models\WalletTransaction;
use Illuminate\Support\Str;

class WalletService
{
    public function registerSale(Booking $booking): WalletTransaction
    {
        $company = $booking->company;
        $gross = $booking->total;
        $percentage = $company->commission_rate;
        $fee = round($gross * ($percentage / 100),2);
        $net = $gross - $fee;

        return WalletTransaction::create([
            'uuid'=>Str::uuid(),
            'company_id'=>$company->id,
            'booking_id'=>$booking->id,
            'type'=>WalletTypeEnum::Sale,
            'status'=>WalletStatusEnum::Pending,
            'description'=>"Reserva #{$booking->id}",
            'gross_amount'=>$gross,
            'fee_percentage'=>$percentage,
            'fee_amount'=>$fee,
            'net_amount'=>$net,
            'available_at'=>now()->addDays(7)
        ]);
    }
}