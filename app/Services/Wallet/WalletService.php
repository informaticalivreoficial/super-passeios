<?php

namespace App\Services\Wallet;

use App\Enums\WalletStatusEnum;
use App\Enums\WalletTypeEnum;
use App\Models\Booking;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletService
{
    public function __construct(
        protected CommissionService $commissionService
    ) {
    }

    public function registerSale(Booking $booking): WalletTransaction
    {
        return DB::transaction(function () use ($booking) {

            $transaction = WalletTransaction::where('booking_id', $booking->id)
                ->lockForUpdate()
                ->first();

            if ($transaction) {
                return $transaction;
            }

            $company = $booking->company;

            $values = $this->commissionService->calculate(
                $company,
                $booking->total
            );

            return WalletTransaction::create([

                'uuid' => Str::uuid(),

                'company_id' => $company->id,

                'booking_id' => $booking->id,

                'type' => WalletTypeEnum::Sale,

                'status' => WalletStatusEnum::Pending,

                'description' => "Reserva #{$booking->id}",

                'gross_amount' => $values['gross_amount'],

                'fee_percentage' => $values['fee_percentage'],

                'fee_amount' => $values['fee_amount'],

                'net_amount' => $values['net_amount'],

                'available_at' => now()->addDays($company->release_days),

            ]);
        });
    }
}