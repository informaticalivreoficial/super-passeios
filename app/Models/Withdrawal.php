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
        'requested_at',
        'approved_at',
        'fee',
        'net_amount',
        'approved_by',
        'payment_reference'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
        'status' => \App\Enums\WithdrawalStatusEnum::class,
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

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function isPending(): bool
    {
        return $this->status === \App\Enums\WithdrawalStatusEnum::REQUESTED;
    }

    public function isApproved(): bool
    {
        return $this->status === \App\Enums\WithdrawalStatusEnum::APPROVED;
    }

    public function isPaid(): bool
    {
        return $this->status === \App\Enums\WithdrawalStatusEnum::PAID;
    }
}
