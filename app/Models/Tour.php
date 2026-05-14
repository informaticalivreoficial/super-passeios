<?php

namespace App\Models;

use App\Support\Cropper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Enums\TourTypeEnum;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'vessel_id',
        'uuid',
        'views',
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
        'tour_type' => TourTypeEnum::class,
    ];

    protected static function boot()
    {
        parent::boot();        
    }

    protected static function booted()
    {
        static::saving(function ($tour) {
            $tour->setSlug();
        });

        static::creating(function ($tour) {
            $tour->uuid   = Str::uuid();
        });

        static::deleting(function ($tour) {
            // Deleta a pasta inteira com todas as imagens
            Storage::disk('public')->deleteDirectory("company/{$tour->company->uuid}/tours/{$tour->uuid}");

            // Deleta os registros do banco
            $tour->images()->delete();
        });
    }

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
        if (!empty($this->title)) {
    
            $baseSlug = Str::slug($this->title);
            $slug = $baseSlug;
            $count = 1;
    
            while (
                Tour::where('slug', $slug)
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
