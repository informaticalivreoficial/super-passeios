<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'company_id',
        'bank_account_id',
        'amount',
        'status',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'amount'  => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($withdrawal) {
            $withdrawal->uuid = (string) Str::uuid();
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'requested';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
