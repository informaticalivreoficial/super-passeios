<?php

namespace App\Services\Wallet;

use App\Enums\WalletStatusEnum;
use App\Enums\WalletTypeEnum;
use App\Models\Booking;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

            if (!$company) {
                throw new \RuntimeException(
                    "Booking #{$booking->id} não possui empresa associada (company_id: {$booking->company_id})."
                );
            }

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

    public function reverseSale(Booking $booking): void
    {
        DB::transaction(function () use ($booking) {

            $original = WalletTransaction::where('booking_id', $booking->id)
                ->where('type', WalletTypeEnum::Sale)
                ->lockForUpdate()
                ->first();

            if (!$original) {
                Log::warning('WalletService: nenhuma transação de venda encontrada para estornar', [
                    'booking_id' => $booking->id,
                ]);
                return;
            }

            // Caso 1: saldo ainda pendente (dentro do período de segurança)
            // Nunca chegou a ficar disponível pra operadora, então só cancela — sem impacto no saldo.
            if ($original->status === WalletStatusEnum::Pending) {
                $original->update(['status' => WalletStatusEnum::Cancelled]);
                return;
            }

            // Caso 2: saldo já estava disponível ou já foi pago/sacado.
            // Não mexe na transação original (preserva o histórico) — cria uma transação
            // negativa de estorno, debitando o valor do saldo da operadora.
            if (in_array($original->status, [WalletStatusEnum::Available, WalletStatusEnum::Paid])) {
                WalletTransaction::create([
                    'uuid' => Str::uuid(),
                    'company_id' => $original->company_id,
                    'booking_id' => $booking->id,
                    'type' => WalletTypeEnum::Refund,
                    'status' => WalletStatusEnum::Available, // já nasce disponível, pois é um débito imediato
                    'description' => "Estorno da reserva #{$booking->id}",
                    'gross_amount' => -$original->gross_amount,
                    'fee_percentage' => $original->fee_percentage,
                    'fee_amount' => -$original->fee_amount,
                    'net_amount' => -$original->net_amount,
                    'available_at' => now(),
                ]);
            }
        });
    }
}