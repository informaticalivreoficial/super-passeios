<?php

namespace App\Models;

use App\Support\Cropper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    protected static function boot()
    {
        parent::boot();        
    }

    protected static function booted()
    {
        static::saving(function ($vessel) {
            $vessel->setSlug();
        });

        static::creating(function ($vessel) {
            $vessel->uuid      = Str::uuid();
        });

        static::deleting(function ($vessel) {
            // Deleta a pasta inteira com todas as imagens
            Storage::disk('public')->deleteDirectory("company/{$vessel->company->uuid}/vessels/{$vessel->uuid}");

            // Deleta os registros do banco
            $vessel->images()->delete();
        });
    }

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
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

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

    public function setSlug()
    {
        if (!empty($this->name)) {
    
            $baseSlug = Str::slug($this->name);
            $slug = $baseSlug;
            $count = 1;
    
            while (
                Vessel::where('slug', $slug)
                    ->where('id', '!=', $this->id)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . str_pad($count, 2, '0', STR_PAD_LEFT);
                $count++;
            }
    
            $this->attributes['slug'] = $slug;
        }
    }
    
}
