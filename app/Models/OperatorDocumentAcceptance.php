<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperatorDocumentAcceptance extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'document_id',
        'version',
        'content_hash',
        'accepted_at',
        'ip_address',
        'user_agent',
        'viewed_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'viewed_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(OperatorDocument::class, 'document_id');
    }
}
