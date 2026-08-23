<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'email',
        'name',
        'active',
        'confirmed_at',
        'unsubscribe_token',
    ];

    protected $casts = [
        'active'       => 'boolean',
        'confirmed_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(NewsletterCategory::class, 'category_id');
    }

    protected static function booted()
    {
        static::creating(function ($newsletter) {
            $newsletter->unsubscribe_token = \Illuminate\Support\Str::random(64);
        });
    }
}
