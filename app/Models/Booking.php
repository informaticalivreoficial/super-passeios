<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function date()
    {
        return $this->belongsTo(TourDate::class, 'tour_date_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
