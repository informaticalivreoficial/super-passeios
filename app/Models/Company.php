<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'uuid',
        'api_token',  
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
        'information',
        'status',
        //Redes Sociais
        'facebook', 'twitter', 'instagram', 'linkedin',
        //contact 
        'phone', 'cell_phone', 'whatsapp', 'telegram', 'email', 'additional_email',
        //Address      
        'zipcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',
    ];

    protected $casts = [
        'status' => 'boolean',
        'magic_token_expires_at' => 'datetime',
        'highlight' => 'boolean',
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
            Storage::disk('public')->deleteDirectory("company/{$company->uuid}");

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

    public function images()
    {
        return $this->hasMany(CompanyGb::class, 'company', 'id')
                    ->orderBy('order_img', 'ASC')
                    ->orderBy('cover', 'DESC'); // cover primeiro (1 antes de 0)
    }    

    public function hasImagesWithoutWatermark()
    {
        return $this->images->where('watermark', false)->isNotEmpty();
    }

    /**
     * Accerssors and Mutators
    */
    public function getLogoUrl(): string
    {
        if ($this->logo && Storage::disk('public')->exists($this->logo)) {
            return Storage::url($this->logo);
        }

        return asset('theme/images/image.jpg');
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
    
    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
