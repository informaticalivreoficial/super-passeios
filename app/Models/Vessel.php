<?php

namespace App\Models;

use App\Support\Cropper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'display_marked_water',
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

    /**
     * Accerssors and Mutators
     */
    public function cover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']) ??
                $images->first(['path']);

        if (!$cover || empty($cover->path)) {
            return asset('theme/images/image.jpg');
        }

        return Storage::url(Cropper::thumb($cover['path'], 720, 480));
    }    

    public function nocover()
    {
        $images = $this->images();

        $cover = $images->where('cover', 1)->first(['path'])
            ?? $images->first(['path']);

        if (empty($cover['path']) || !Storage::disk()->exists($cover['path'])) {
            return asset('theme/images/image.jpg');
        }
        
        return Storage::url($cover['path']);
    } 
    
}
