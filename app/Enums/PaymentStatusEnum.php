<?php

namespace App\Enums;

enum PaymentStatusEnum:string
{
    case PENDING  = 'PENDING';
    case PAID     = 'PAID';
    case REFUSED  = 'REFUSED';
    case REFUNDED = 'REFUNDED';
    case EXPIRED  = 'EXPIRED';

    public function label(): string
    {
        return match($this) {
            self::PENDING   => 'Aguardando',
            self::PAID      => 'Pago',
            self::REFUSED   => 'Recusado',
            self::REFUNDED  => 'Reembolsado',
            self::EXPIRED   => 'Expirado',
        };
    }
}