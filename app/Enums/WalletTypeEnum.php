<?php

namespace App\Enums;

enum WalletTypeEnum:string
{
    case Sale='sale';
    case Withdrawal='withdrawal';
    case Refund='refund';
    case Adjustment='adjustment';
    case Bonus='bonus';
}