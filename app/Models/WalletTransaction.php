<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'booking_id',
        'uuid',
        'type',
        'status',
        'description',
        'gross_amount',
        'fee_percentage',
        'fee_amount',
        'net_amount',
        'available_at',
        'paid_at'
    ];

    protected $casts=[
        'available_at'=>'datetime',
        'paid_at'=>'datetime'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
