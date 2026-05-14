<?php

namespace App\Enums;

enum BookingStatusEnum:string
{
    case PENDING   = 'PENDING';
    case CONFIRMED = 'CONFIRMED';
    case CANCELLED = 'CANCELLED';
    case COMPLETED = 'COMPLETED';
    case NO_SHOW   = 'NO_SHOW';
}