<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Casts\TimeCast;
use App\Enums\TourDateStatusEnum;

class TourDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'date',
        'start_time',
        'end_time',
        'available_slots',
        'half_price',
        'active',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'date' => 'date',
        'active' => 'boolean',
        'start_time' => TimeCast::class,
        'end_time'   => TimeCast::class,
        'status' => TourDateStatusEnum::class,
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeAvailable($query)
    {
        return $query
            ->where('active', true)
            ->where('date', '>=', now()->toDateString())
            ->where('status', TourDateStatusEnum::OPEN)
            ->whereRaw('available_slots > (
                SELECT COALESCE(SUM(adults + children), 0)
                FROM bookings
                WHERE bookings.tour_date_id = tour_dates.id
                AND bookings.payment_status IN (?, ?)
            )', ['paid', 'pending']);
    }

    public function getRemainingAvailableAttribute(): int
    {
        $booked = $this->bookings()
            ->whereIn('payment_status', ['paid', 'pending'])
            ->sum(DB::raw('adults + children'));

        return max($this->attributes['available_slots'] - $booked, 0);
    }

    public function getBookedSlotsAttribute(): int
    {
        return $this->bookings()
            ->whereIn('payment_status', ['paid', 'pending'])
            ->sum(DB::raw('adults + children'));
    }

    public function getIsSoldOutAttribute(): bool
    {
        return $this->available_slots <= 0;
    }

    public function getRemainingSlotsAttribute()
    {
        $booked =
            $this->bookings()
                ->whereIn('status', ['confirmed', 'pending'])
                ->sum(DB::raw('adults + children'));

        return max(0, $this->available_slots - $booked);
    }    
}
