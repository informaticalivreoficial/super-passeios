<?php

namespace App\Models;

use App\Enums\WalletStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $hidden = [
        'api_token',
        'magic_token',
        'magic_token_expires_at',
    ];

    protected $fillable = [
        'uuid',
        'commission_rate',
        'release_days',
        'responsable_name',
        'responsable_email',
        'responsable_cpf',      
        'content',
        'url',
        'slug',
        'first_year',
        'maps',
        'logo',
        'metaimg',
        'caption_img_cover',
        'highlight',
        'magic_token',
        'magic_token_expires_at',
        'social_name',
        'alias_name',
        'document_company',
        'document_company_secondary',
        'cadastur',
        'information',
        'status',
        'deletion_requested_at',
        'deletion_scheduled_for',
        'deletion_cancelled_at',
        //Redes Sociais
        'facebook', 'twitter', 'instagram', 'linkedin', 'tiktok',
        //contact 
        'phone', 'cell_phone', 'whatsapp', 'telegram', 'email', 'additional_email',
        //Address      
        'zipcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',
    ];

    protected $casts = [
        'status' => 'boolean',
        'magic_token_expires_at' => 'datetime',
        'highlight' => 'boolean',
        'commission_rate' => 'decimal:2',
        'deletion_requested_at' => 'datetime',
        'deletion_scheduled_for' => 'datetime',
        'deletion_cancelled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();        
    }

    protected static function booted()
    {
        static::saving(function ($company) {
            $company->setSlug();
        });

        static::creating(function ($company) {
            $company->uuid      = Str::uuid();
            $company->api_token = Str::random(64);
        });

        static::deleting(function ($company) {
            // Deleta a pasta inteira com todas as imagens
            Storage::disk()->deleteDirectory("company/{$company->uuid}");

            // Deleta os registros do banco
            $company->images()->delete();
        });
    }

    // Gera novo token manualmente se precisar
    public function regenerateToken(): string
    {
        $token = Str::random(64);
        $this->update(['api_token' => $token]);
        return $token;
    }

    public function isDeletionPending(): bool
    {
        return $this->deletion_requested_at !== null
            && $this->deletion_cancelled_at === null;
    }

    public function isDeletionCancelled(): bool
    {
        return $this->deletion_cancelled_at !== null;
    }

    /**
     * Scopes
    */
    

    /**
     * Relationships
    */ 
    public function vessels()
    {
        return $this->hasMany(Vessel::class);
    }   

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function owner()
    {
        return $this->hasOne(Customer::class)->whereHas('roles', function ($query) {
            $query->where('name', 'proprietary');
        });
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(
            Booking::class,
            Tour::class,
            'company_id', // FK em tours
            'tour_id',    // FK em bookings
        );
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function images()
    {
        return $this->hasMany(CompanyGb::class, 'company', 'id')
                    ->orderBy('order_img', 'ASC')
                    ->orderBy('cover', 'DESC'); // cover primeiro (1 antes de 0)
    } 
    
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function defaultBankAccount()
    {
        return $this->hasOne(BankAccount::class)->where('is_default', true);
    }

    /**
     * Accerssors and Mutators
    */
    public function getLogoUrl(): string
    {
        if ($this->logo && Storage::disk()->exists($this->logo)) {
            return Storage::url($this->logo);
        }

        return asset('theme/images/image.jpg');
    }

    public function getAvailableBalanceAttribute(): float
    {
        return (float) $this->walletTransactions()
            ->where('status', \App\Enums\WalletStatusEnum::Available)
            ->sum('net_amount');
    }

    public function getPendingBalanceAttribute()
    {
        return $this->walletTransactions()
            ->where('status', WalletStatusEnum::Pending)
            ->sum('net_amount');
    }

    public function getTotalCommissionAttribute()
    {
        return $this->walletTransactions()
            ->sum('fee_amount');
    }

    public function getTotalSalesAttribute(): float
    {
        return (float) $this->walletTransactions()
            ->where('type', \App\Enums\WalletTypeEnum::Sale)
            ->sum('gross_amount');
    }

    public function getTotalWithdrawnAttribute(): float
    {
        return (float) abs(
            $this->walletTransactions()
                ->where('type', \App\Enums\WalletTypeEnum::Withdrawal)
                ->sum('net_amount')
        );
    }

    public function getCancelledBalanceAttribute(): float
    {
        return (float) abs(
            $this->walletTransactions()
                ->where('status', WalletStatusEnum::Cancelled)
                ->sum('net_amount')
        );
    }

    // Usar no Blade
    // $company->available_balance;
    // $company->pending_balance;
    // $company->total_commission;

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

    public function setDocumentCompanyAttribute($value)
    {
        $this->attributes['document_company'] = (!empty($value) ? $this->clearField($value) : null);
    }


    public function getDocumentCompanyAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) .
            '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
    }

    public function setCadasturAttribute($value)
    {
        $this->attributes['cadastur'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function setCellPhoneAttribute($value)
    {
        $this->attributes['cell_phone'] = (!empty($value) ? $this->clearField($value) : null);
    }  

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = (!empty($value) ? $this->clearField($value) : null);
    }    

    public function setWhatsappAttribute($value)
    {
        $this->attributes['whatsapp'] = (!empty($value) ? $this->clearField($value) : null);
    }    

    private function formatPhone(?string $value): ?string
    {
        if (empty($value)) return null;

        return '(' . substr($value, 0, 2) . ') ' . substr($value, 2, 5) . '-' . substr($value, 7, 4);
    }

    public function getPhoneAttribute($value): ?string
    {
        return $this->formatPhone($value);
    }

    public function getCellPhoneAttribute($value): ?string
    {
        return $this->formatPhone($value);
    }

    public function getWhatsappAttribute($value): ?string
    {
        return $this->formatPhone($value);
    }

    public function generateMagicToken(): string
    {
        $token = \Illuminate\Support\Str::random(64);

        $this->update([
            'magic_token'            => $token,
            'magic_token_expires_at' => now()->addMinutes(15),
        ]);

        return $token;
    }

    public function isMagicTokenValid(string $token): bool
    {
        return $this->magic_token === $token
            && $this->magic_token_expires_at
            && $this->magic_token_expires_at->isFuture();
    }

    public function setSlug()
    {
        if (!empty($this->alias_name)) {
    
            $baseSlug = Str::slug($this->alias_name);
            $slug = $baseSlug;
            $count = 1;
    
            while (
                Company::where('slug', $slug)
                    ->where('id', '!=', $this->id)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . str_pad($count, 2, '0', STR_PAD_LEFT);
                $count++;
            }
    
            $this->attributes['slug'] = $slug;
        }
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }    

    
    
    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
