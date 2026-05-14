<?php

namespace App\Enums;

enum PaymentStatusEnum:string
{
    case PENDING  = 'PENDING';
    case PAID     = 'PAID';
    case REFUSED  = 'REFUSED';
    case REFUNDED = 'REFUNDED';
    case EXPIRED  = 'EXPIRED';
}