<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            $model->generateSlug();
        });
    }

    public function newsletters()
    {
        return $this->hasMany(Newsletter::class, 'category_id');
    }

    public function generateSlug(): void
    {
        if (!$this->name) {
            return;
        }

        $baseSlug = Str::slug($this->name);
        $slug = $baseSlug;
        $count = 1;

        while (
            self::where('slug', $slug)
                ->when($this->exists, fn ($q) => $q->where('id', '!=', $this->id))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . str_pad($count, 2, '0', STR_PAD_LEFT);
            $count++;
        }

        $this->slug = $slug;
    }
}
