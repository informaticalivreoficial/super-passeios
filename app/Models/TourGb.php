<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TourGb extends Model
{
    use HasFactory;

    protected $table = 'tour_gbs'; 

    protected $fillable = [
        'tour_id',
        'order_img',
        'watermark',        
        'path',
        'cover'
    ];

    protected $casts = [
        'cover' => 'boolean',
    ];

    public function getUrlCroppedAttribute()
    {
        return Storage::url($this->path);
    }

    public function getUrlImageAttribute()
    {
        return Storage::url($this->path);
    }
}
