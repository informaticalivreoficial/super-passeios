<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
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
        'information'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthday' => 'date',
    ];

    protected static function booted()
    {
        static::deleting(function ($user) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
        });
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isCompany(): bool
    {
        return $this->hasRole('company');
    }

    /**
     * Relacionamentos
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'autor', 'id');
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Accerssors and Mutators
    */
    public function getUrlAvatarAttribute(): string
    {
        if (!empty($this->avatar) && Storage::disk('public')->exists($this->avatar)) {
            return Storage::url($this->avatar);
        }

        return asset('theme/images/image.jpg');
    }

    public function setCellPhoneAttribute($value)
    {
        $this->attributes['cell_phone'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getCellPhoneAttribute($value): ?string
    {
        return $this->formatPhone($value);
    }

    

    public function setWhatsappAttribute($value)
    {
        $this->attributes['whatsapp'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getWhatsappAttribute($value): ?string
    {
        return $this->formatPhone($value);
    }    

    public function setZipcodeAttribute($value)
    {
        $this->attributes['zipcode'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getZipcodeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return substr($value, 0, 5) . '-' . substr($value, 5, 3);
    }

    private function convertStringToDouble(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
    }    
    
    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }

    private function formatPhone(?string $value): ?string
    {
        if (empty($value)) return null;

        $v = $this->clearField($value);

        if (strlen($v) === 11) {
            return "({$v[0]}{$v[1]}) " . substr($v, 2, 5) . '-' . substr($v, 7, 4);
        }

        if (strlen($v) === 10) {
            return "({$v[0]}{$v[1]}) " . substr($v, 2, 4) . '-' . substr($v, 6, 4);
        }

        return $value;
    }

    // Converte d/m/Y → Y-m-d ao salvar
    public function setBirthdayAttribute($value): void
    {
        if ($value && str_contains($value, '/')) {
            $this->attributes['birthday'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['birthday'] = $value;
        }
    }

    // Converte Y-m-d → d/m/Y ao ler
    public function getBirthdayAttribute($value): ?string
    {
        if (!$value) return null;
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
}
