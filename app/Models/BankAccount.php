<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'company_id',
        'type',
        'pix_type',
        'pix_key',
        'bank_code',
        'bank_name',
        'agency',
        'agency_digit',
        'account',
        'account_digit',
        'account_type',
        'holder_name',
        'holder_document',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($account) {
            $account->uuid = (string) Str::uuid();
        });

        // garante só uma conta default por company
        static::saved(function ($account) {
            if ($account->is_default) {
                BankAccount::where('company_id', $account->company_id)
                    ->where('id', '!=', $account->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getLabelAttribute(): string
    {
        if ($this->type === 'pix') {
            return "PIX · {$this->pix_type}: {$this->pix_key}";
        }

        return "{$this->bank_name} · Ag {$this->agency} · CC {$this->account}-{$this->account_digit}";
    }
}
