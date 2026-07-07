<?php

namespace App\Enums;

enum BookingStatusEnum:string
{
    case PENDING   = 'PENDING';
    case CONFIRMED = 'CONFIRMED';
    case CANCELLED = 'CANCELLED';
    case COMPLETED = 'COMPLETED';
    case NO_SHOW   = 'NO_SHOW';

    public function label(): string
    {
        return match($this) {
            self::PENDING   => 'Aguardando pagamento',
            self::CONFIRMED => 'Confirmado',
            self::CANCELLED => 'Cancelado',
            self::COMPLETED => 'Concluído',
            self::NO_SHOW   => 'Não compareceu',
        };
    }
}