<?php

namespace App\Livewire\Dashboard\Companies;

use App\Models\CatCompany;
use App\Models\Company;
use App\Models\CompanyGb;
use App\Models\Config;
use App\Services\ViaCepService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Traits\WithToastr;

class CompanyForm extends Component
{
    use WithFileUploads, WithToastr;

    public ?Company $company = null;

    public $logo;
    public ?string $logoPath = null;

    public $metaimg;
    public ?string $metaimgPath = null;

    public string $currentTab = 'dados'; 

    public array $images = [];
    public $savedImages = [];  
    
    public array $metatags = [];

    public ?string $caption_img_cover = null;

    public ?string $responsable_name = null;
    public ?string $responsable_email = null;
    public ?string $responsable_cpf = null;
    public ?string $social_name = null;
    public ?string $alias_name = null;
    public ?string $document_company = null;
    public ?string $document_company_secondary = null;
    public ?string $information = null;        
    
    public ?string $content = null;
    public ?string $url = null;
    public ?string $first_year = null;
    public ?string $maps = null;

    public ?string $status    = '0';
    public ?string $highlight = '0';
    public ?string $facebook = null;
    public ?string $twitter = null;
    public ?string $instagram = null;
    public ?string $linkedin = null;

    //Contact
    public $phone, $cell_phone, $whatsapp, $email, $additional_email, $telegram;

    //Address
    public $zipcode = '', $street, $neighborhood, $city, $state, $complement, $number;

    protected function rules()
    {
        $companyId = $this->company->id ?? null;

        return [
            'alias_name'        => 'required|string|max:255',
            'responsable_name'  => 'required|string|max:255',
            'responsable_email' => 'required|string|email|max:255',
            'zipcode'           => 'required|min:8|max:10',
            'email'             => ['required', 'email', Rule::unique('companies', 'email')->ignore($companyId)],
            'cell_phone'        => 'required|string|min:14',
            'logo'              => 'nullable|file|mimes:jpeg,jpg,png,webp|max:2048',
        ];
    }  
    
    protected function messages(): array
    {
        return [
            'alias_name.required' => 'O nome fantasia é obrigatório.',
            'alias_name.max' => 'O nome fantasia deve ter no máximo 255 caracteres.',

            'responsable_name.required' => 'O nome do responsável é obrigatório.',
            'responsable_name.max' => 'O nome do responsável deve ter no máximo 255 caracteres.',

            'responsable_email.required' => 'O e-mail do responsável é obrigatório.',
            'responsable_email.email' => 'Informe um e-mail válido para o responsável.',
            'responsable_email.max' => 'O e-mail do responsável deve ter no máximo 255 caracteres.',

            'zipcode.required' => 'O CEP é obrigatório.',
            'zipcode.min' => 'O CEP informado é inválido.',
            'zipcode.max' => 'O CEP informado é inválido.',

            'email.required' => 'O e-mail da empresa é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',

            'cell_phone.required' => 'O celular é obrigatório.',
            'cell_phone.min' => 'Informe um celular válido.',

            'logo.file' => 'O arquivo enviado é inválido.',
            'logo.mimes' => 'A logomarca deve estar nos formatos JPG, JPEG, PNG ou WEBP.',
            'logo.max' => 'A logomarca não pode ultrapassar 2MB.',
        ];
    }

    public function mount(Company $company)
    {
        $this->company = $company;

        if ($company->exists) {
            $this->logoPath   = $company->logo;
            $this->metaimgPath = $company->metaimg; // 👈 essencial

            $data = collect($company->toArray())->toArray();
            $this->fill($data);

            $this->status    = (string) (int) ($company->status    ?? false);
            $this->highlight = (string) (int) ($company->highlight ?? false);

            // Metatags como array
            $this->metatags = is_string($company->metatags)
                ? explode(',', $company->metatags)
                : [];
           
        }
    }

    public function save(string $mode = 'draft')
    {
        try {
            // 🔹 Regras dinâmicas
            $rules = $this->rules();

            if (! $this->logo instanceof TemporaryUploadedFile) {
                unset($rules['logo']);
            }       

            // 🔹 Validação
            $validated = $this->validate($rules);

            // 🔹 Ajustes
            $validated['status']   = $mode === 'published' ? 1 : 0;

            // 🔹 Monta payload
            $data = [
                'responsable_name' => $validated['responsable_name'],
                'responsable_email' => $validated['responsable_email'],
                'responsable_cpf' => $this->responsable_cpf,
                'alias_name' => $validated['alias_name'],
                'email' => $validated['email'],

                'maps' => $this->maps,

                'status' => $validated['status'],
                'guia' => $this->guia ?? 0,
                'client' => $this->client ?? 0,
                'highlight' => $this->highlight ?? 0,

                'url' => $this->url,
                'first_year' => $this->first_year,
                'content' => $this->content,
                'caption_img_cover' => $this->caption_img_cover,

                'social_name' => $this->social_name,
                'zipcode' => $this->zipcode,
                'street' => $this->street,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'state' => $this->state,
                'complement' => $this->complement,
                'number' => $this->number,

                'additional_email' => $this->additional_email,
                'document_company' => $this->document_company,
                'document_company_secondary' => $this->document_company_secondary,
                'information' => $this->information,

                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'instagram' => $this->instagram,
                'linkedin' => $this->linkedin,

                'phone' => $this->phone,
                'whatsapp' => $this->whatsapp,
                'telegram' => $this->telegram,
                'cell_phone' => $validated['cell_phone'],
            ];

            // 🔹 Create ou Update
            if ($this->company->exists) {
                $this->company->update($data);
            } else {
                $this->company = Company::create($data);
            }

            // 🔹 Agora já tem ID
            $folder = 'company/' . $this->company->uuid;
            $manager = new ImageManager(new Driver());

            // 🔹 Upload logo
            if ($this->logo instanceof TemporaryUploadedFile) {
                if ($this->logoPath && Storage::disk('public')->exists($this->logoPath)) {
                    Storage::disk('public')->delete($this->logoPath);
                }

                $filename = uniqid('logo_') . '.webp';
                $path = "{$folder}/{$filename}";

                $img = $manager->read($this->logo->getRealPath())
                    ->scaleDown(width: config('app.logomarca_width', 600))
                    ->toWebp(85);

                Storage::disk('public')->put($path, $img);

                $this->logoPath = $path;
                $this->company->update(['logo' => $path]);
            }

            // 🔹 Upload metaimg
            if ($this->metaimg instanceof TemporaryUploadedFile) {
                if ($this->metaimgPath && Storage::disk('public')->exists($this->metaimgPath)) {
                    Storage::disk('public')->delete($this->metaimgPath);
                }

                $filename = uniqid('metaimg_') . '.webp';
                $path = "{$folder}/{$filename}";

                $img = $manager->read($this->metaimg->getRealPath())
                    ->scaleDown(width: config('app.metaimg_width', 1200))
                    ->toWebp(85);

                Storage::disk('public')->put($path, $img);

                $this->metaimgPath = $path;
                $this->company->update(['metaimg' => $path]);
            }

            // 🔹 Validação imagens múltiplas
            $this->validate([
                'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
            ]);

            $maxImages = config('app.max_images');
            $existingImages = $this->company->images()->count();
            $allowed = $maxImages - $existingImages;

            if (count($this->images ?? []) > $allowed) {
                $this->dispatch('swal:warning', [
                    'title' => 'Atenção!',
                    'text' => "Limite de {$maxImages} imagens atingido.",
                    'icon' => 'warning',
                    'showConfirmButton' => false
                ]);
                return;
            }

            foreach ($this->images as $index => $image) {

                if ($index >= $allowed) break;

                $filename = uniqid() . '.webp';
                $path = "{$folder}/{$filename}";

                $img = $manager->read($image->getRealPath())
                    ->scaleDown(width: 1920)
                    ->toWebp(85);

                Storage::disk('public')->put($path, $img);

                $maxOrder = CompanyGb::where('company', $this->company->id)->max('order_img') ?? 0;

                CompanyGb::create([
                    'company' => $this->company->id,
                    'path' => $path,
                    'cover' => $this->cover ?? null,
                    'order_img' => $maxOrder + $index + 1,
                    'watermark' => false
                ]);
            }

            $this->reset('images');

            // 🔹 Feedback
            $this->dispatch('swal:success', [
                'title' => 'Sucesso!',
                'text' => $this->company->wasRecentlyCreated
                    ? 'Empresa cadastrada com sucesso!'
                    : 'Empresa atualizada com sucesso!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);

            // 🔹 Redirect
            if ($this->company->wasRecentlyCreated) {
                return redirect()->route('admin.companies.edit', $this->company);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('scroll-to-first-error');
            $this->toastError($e->validator->errors()->first());
            throw $e;
        }        
    }

    //Remover imagem temporária
    public function removeTempImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    //Remover imagem do Bd
    public function removeSavedImage($id)
    {
        $image = CompanyGb::find($id);
        if ($image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
            $this->savedImages = collect($this->savedImages)->filter(fn ($img) => $img->id !== $id);
            $this->company->refresh(); // Para garantir que os dados estejam atualizados
        }
    }

    public function toggleCover($imageId)
    {
        $image = CompanyGb::where('id', $imageId)->where('company', $this->company->id)->first();

        if ($image) {
            if ($image->cover) {
                // Se já é capa, remove
                $image->update(['cover' => 0]);
            } else {
                // Remove capa das outras e define esta
                CompanyGb::where('company', $this->company->id)->update(['cover' => 0]);
                $image->update(['cover' => 1]);
            }

            // Atualiza a relação para refletir na view
            $this->company->refresh();
        }
    }

    public function updatedZipcode(
        string $value,
        ViaCepService $viaCep
    ) {
        $data = $viaCep->find($value);

        if (!$data) {
            $this->addError('zipcode', 'CEP não encontrado.');
            return;
        }

        $this->street       = $data['logradouro'] ?? '';
        $this->neighborhood = $data['bairro'] ?? '';
        $this->city         = $data['localidade'] ?? '';
        $this->state        = $data['uf'] ?? '';
        $this->complement   = $data['complemento'] ?? '';
    }  

    #[On('updateContent')]
    public function updateContent($value)
    {
        $this->content = $value;
    }

    public function updateImageOrder($order)
    {
        try {
            foreach ($order as $item) {
                CompanyGb::where('id', $item['id'])
                    ->where('company', $this->company->id)
                    ->update(['order_img' => $item['position']]);
            }
            
            // Atualiza a propriedade para refletir a nova ordem
            $this->company->refresh();
            
        } catch (\Exception $e) {
            $this->toastError('Erro ao atualizar ordem das imagens: ' . $e->getMessage());
        }
    }   

    public function updatedImages(): void
    {
        $hasHeic = collect($this->images)->contains(function ($image) {
            return strtolower($image->getClientOriginalExtension()) === 'heic';
        });

        if ($hasHeic) {
            $this->dispatch('swal:warning', [
                'title' => 'Formato não suportado!',
                'text'  => 'Imagens no formato HEIC (iPhone) não são aceitas. Converta para JPG ou PNG antes de enviar.',
                'icon'  => 'warning',
            ]);

            $this->reset('images');
        }
    }

    public function getLogoUrlProperty(): string
    {
        if ($this->logo instanceof TemporaryUploadedFile) {
            return $this->logo->temporaryUrl();
        }

        if ($this->logoPath && Storage::disk('public')->exists($this->logoPath)) {
            return Storage::url($this->logoPath);
        }

        return asset('theme/images/image.jpg');
    }

    public function getMetaimgUrlProperty(): string
    {
        if ($this->metaimg instanceof TemporaryUploadedFile) {
            return $this->metaimg->temporaryUrl();
        }

        if ($this->metaimgPath && Storage::disk('public')->exists($this->metaimgPath)) {
            return Storage::url($this->metaimgPath);
        }

        return asset('theme/images/image.jpg');
    }

    public function render()
    {
        $title = $this->company->exists ? 'Editar Empresa' : 'Cadastrar Empresa';
        return view('livewire.dashboard.companies.company-form')->with('title', $title);
    }
}
