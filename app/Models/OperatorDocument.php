<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatorDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'description',
        'content',
        'version',
        'is_required',
        'is_active',
        'published_at',
        'effective_at',
        'expires_at',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'effective_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function acceptances(): HasMany
    {
        return $this->hasMany(OperatorDocumentAcceptance::class, 'document_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
                     ->whereNotNull('published_at');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function isPublished(): bool
    {
        return $this->is_active && $this->published_at !== null;
    }

    public function isDraft(): bool
    {
        return $this->published_at === null;
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function contentHash(): string
    {
        return hash('sha256', $this->content);
    }

    public function getLatestVersion(?string $type = null): ?self
    {
        $query = self::where('type', $this->type)
            ->where('id', '!=', $this->id)
            ->orderByDesc('version');

        if ($type) {
            $query->where('type', $type);
        }

        return $query->first();
    }

    public function getLatestPublishedForType(): ?self
    {
        return self::where('type', $this->type)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('id', '!=', $this->id)
            ->orderByDesc('version')
            ->first();
    }
}
