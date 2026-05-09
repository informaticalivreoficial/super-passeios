<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'uuid',
        'name',
        'slug',
        'type',
        'capacity',
        'year',
        'size',
        'description',
        'bathroom',
        'barbecue',
        'suite',
        'sound_system',
        'kitchen',
        'active',
    ];

    protected $casts = [
        'bathroom' => 'boolean',
        'barbecue' => 'boolean',
        'suite' => 'boolean',
        'sound_system' => 'boolean',
        'kitchen' => 'boolean',
        'active' => 'boolean',
    ];    

     /**
     * Relationships
    */ 
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function images()
    {
        return $this->hasMany(VesselGb::class, 'vessel_id', 'id')
                    ->orderBy('order_img', 'ASC')
                    ->orderBy('cover', 'DESC'); // cover primeiro (1 antes de 0)
    }
    
}
