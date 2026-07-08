<?php

namespace App\Models;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'company_id',
        'customer_id',
        'tour_date_id',
        'user_id',
        'uuid',
        'customer_name',
        'customer_email',
        'customer_phone',
        'adults',
        'children',
        'payment_method',
        'payment_id',
        'subtotal',
        'commission_amount',    
        'company_amount',
        'total',
        'status',
        'payment_status',
        'paid_at',
        'expires_at', 
        'cancelled_at',    
        'cancelled_reason'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'adults' => 'integer',
        'children' => 'integer',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
        'status' => BookingStatusEnum::class,
        'payment_status' => PaymentStatusEnum::class,
    ];

    protected static function boot()
    {
        parent::boot();        
    }

    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->uuid = (string) Str::uuid();
        });
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function tourDate()
    {
        return $this->belongsTo(TourDate::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function getTotalPeopleAttribute(): int
    {
        return (int) $this->adults + (int) $this->children;
    }

    public function walletTransaction()
    {
        return $this->hasOne(WalletTransaction::class);
    }
}
