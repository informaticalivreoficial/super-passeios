<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsletterCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'body',
        'total_recipients',
        'status',
    ];

    protected $casts = [
        'total_recipients' => 'integer',
    ];

    public function sends(): HasMany
    {
        return $this->hasMany(NewsletterSend::class, 'campaign_id');
    }
}
