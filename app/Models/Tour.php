<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'vessel_id',
        'uuid',
        'title',
        'slug',
        'tour_type',
        'price',
        'duration',
        'boarding_place',
        'description',
        'rules',
        'active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }

    public function dates()
    {
        return $this->hasMany(TourDate::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->hasMany(TourGb::class, 'tour_id', 'id')
                    ->orderBy('order_img', 'ASC')
                    ->orderBy('cover', 'DESC'); // cover primeiro (1 antes de 0)
    }
}
