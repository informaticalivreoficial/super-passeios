<?php

namespace App\Enums;

enum WithdrawalStatusEnum: string
{
    case REQUESTED = 'requested';
    case CANCELLED = 'cancelled';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PAID = 'paid';

    public function label(): string
    {
        return match($this) {
            self::REQUESTED => 'Solicitado',
            self::CANCELLED => 'Cancelado',
            self::APPROVED => 'Aprovado',
            self::REJECTED => 'Rejeitado',
            self::PAID => 'Pago',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::REQUESTED => '#d97706',
            self::CANCELLED => '#a3a3a3',
            self::APPROVED => '#6366f1',
            self::REJECTED => '#dc2626',
            self::PAID => '#15803d',
        };
    }
}