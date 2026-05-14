<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'tour_date_id',
        'user_id',
        'uuid',
        'customer_name',
        'customer_email',
        'customer_phone',
        'adults',
        'children',
        'total',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'adults' => 'integer',
        'children' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();        
    }

    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->uuid = Str::uuid();
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalPeopleAttribute(): int
    {
        return (int) $this->adults + (int) $this->children;
    }
}
