<?php

namespace App\Enums;

enum WalletStatusEnum:string
{
    case Pending='pending';
    case Available='available';
    case Paid='paid';
    case Cancelled='cancelled';
}