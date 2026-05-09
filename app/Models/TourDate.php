<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'date',
        'start_time',
        'end_time',
        'available_slots',
        'active',
    ];

    protected $casts = [
        'date' => 'date',
        'active' => 'boolean',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
