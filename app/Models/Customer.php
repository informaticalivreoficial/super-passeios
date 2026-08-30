<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, HasApiTokens;

    protected $guard_name = 'customer';

    protected $fillable = [
        'company_id',
        'name', 'password', 'remember_token',
        'gender',
        'cpf',
        'rg',
        'rg_expedition',
        'birthday',
        'naturalness',
        'civil_status',
        'avatar',  
        //Address      
        'zipcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',
        //Contact
        'phone', 'cell_phone', 'whatsapp', 'telegram', 'email', 'additional_email',
        //Social
        'facebook', 'twitter', 'instagram', 'linkedin',        
        'status',
        'information',
        'magic_token', 'magic_token_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'magic_token',
    ];

    protected $casts = [
        'email_verified_at'      => 'datetime',
        'magic_token_expires_at' => 'datetime',
        //'birthday'               => 'date',
        'status'                 => 'boolean',
    ];
    
    public function isProprietary(): bool
    {
        return $this->hasRole('proprietary');
    }

    public function isClient(): bool
    {
        return $this->hasRole('client');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getUrlAvatarAttribute(): string
    {
        if (!empty($this->avatar) && Storage::disk('r2')->exists($this->avatar)) {
            return Storage::url($this->avatar);
        }

        return asset('theme/images/image.jpg');
    }

    public function setBirthdayAttribute($value): void
    {
        if ($value && str_contains($value, '/')) {
            $this->attributes['birthday'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['birthday'] = $value;
        }
    }

    public function getBirthdayAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }
}
