<?php

namespace App\Livewire\Company\Company;

use App\Models\Company;
use App\Models\CompanyGb;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyForm extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public ?Company $company = null;

    // Imagens
    public array $images = [];
    public $savedImages = [];
    public $logo;
    public $metaimg;
    public $logoPreview = null;
    public $metaimgPreview = null;

    public ?string $logoPath = null;
    public ?string $metaimgPath = null;

    // Dados principais
    public ?string $social_name = null;
    public ?string $alias_name = null;
    public ?string $document_company = null;
    public ?string $document_company_secondary = null;
    public ?string $cadastur = null;
    public ?string $content = null;
    public ?string $url = null;
    public ?string $caption_img_cover = null;    

    // Contato
    public ?string $phone = null;
    public ?string $cell_phone = null;
    public ?string $whatsapp = null;
    public ?string $telegram = null;
    public ?string $email = null;
    public ?string $additional_email = null;

    // Endereço
    public string $zipcode = '';
    public ?string $street = null;
    public ?string $neighborhood = null;
    public ?string $city = null;
    public ?string $state = null;
    public ?string $complement = null;
    public ?string $number = null;

    // Redes sociais
    public ?string $facebook  = null;
    public ?string $twitter   = null;
    public ?string $instagram = null;
    public ?string $linkedin  = null;
    public ?string $tiktok    = null;

    public function mount(): void
    {
        $user = auth()->user();

        // Se o usuário já tem empresa, carrega para edição
        if ($user->company) {

            $this->company = $user->company;
            $this->authorize('update', $this->company);
            $this->fillForm();

            $this->logoPreview = $this->company->logo
                ? Storage::url($this->company->logo)
                : null;

            $this->metaimgPreview = $this->company->metaimg
                ? Storage::url($this->company->metaimg)
                : null;
        } else {

            $this->authorize('create', Company::class);
            $this->company = new Company();
            
        }

        $this->savedImages = $this->company->exists
            ? $this->company->images()->orderBy('order_img')->get()
            : collect();
    }

    private function fillForm(): void
    {
        $c = $this->company;

        $this->social_name                = $c->social_name;
        $this->alias_name                 = $c->alias_name;
        $this->document_company           = $c->document_company;
        $this->document_company_secondary = $c->document_company_secondary;
        $this->cadastur                   = $c->cadastur;
        $this->content                    = $c->content;
        $this->url                        = $c->url;
        
        $this->phone                    = $c->phone;
        $this->cell_phone               = $c->cell_phone;
        $this->whatsapp                 = $c->whatsapp;
        $this->telegram                 = $c->telegram;
        $this->email                    = $c->email;
        $this->additional_email         = $c->additional_email;

        $this->zipcode                  = $c->zipcode ?? '';
        $this->street                   = $c->street;
        $this->neighborhood             = $c->neighborhood;
        $this->city                     = $c->city;
        $this->state                    = $c->state;
        $this->complement               = $c->complement;
        $this->number                   = $c->number;

        $this->facebook                 = $c->facebook;
        $this->twitter                  = $c->twitter;
        $this->instagram                = $c->instagram;
        $this->linkedin                 = $c->linkedin;
        $this->tiktok                   = $c->tiktok;
    }

    protected function rules(): array
    {
        $companyId = $this->company->id ?? null;

        return [
            'alias_name'   => 'required|string|max:255',
            'email'        => ['required', 'email', Rule::unique('companies', 'email')->ignore($companyId)],
            'whatsapp'     => 'required|string|min:14',
            'logo'         => 'nullable|file|mimes:jpeg,jpg,png,webp|max:2048',
            'metaimg'      => 'nullable|file|mimes:jpeg,jpg,png,webp|max:2048',
        ];
    }

    protected $messages = [
        'type.required' => 'Selecione o tipo.',
        'type.string' => 'O tipo informado é inválido.',

        'alias_name.required' => 'O nome da empresa é obrigatório.',
        'alias_name.min' => 'O nome da empresa deve ter no mínimo :min caracteres.',
        'alias_name.max' => 'O nome da empresa deve ter no máximo :max caracteres.',
        'alias_name.string' => 'O nome da empresa informado é inválido.',

        'content.required' => 'O conteúdo é obrigatório.',
        'content.string' => 'O conteúdo informado é inválido.',

        'status.required' => 'Selecione o status.',
        'status.boolean' => 'O status informado é inválido.',

        'images.*.image' => 'O arquivo deve ser uma imagem válida.',
        'images.*.mimes' => 'A imagem deve ser do tipo: jpeg, jpg, png ou webp.',
        'images.*.max' => 'A imagem não pode ultrapassar 2MB.',
    ]; 

    public function save(): void
    {
        try {
            // Regras dinâmicas — remove validação de arquivo se não foi enviado novo
            $rules = $this->rules();

            if (! $this->logo instanceof TemporaryUploadedFile) {
                unset($rules['logo']);
            } 

            if (! $this->metaimg instanceof TemporaryUploadedFile) {
                unset($rules['metaimg']);
            }        

            $this->validate($rules);

            $data = [
                'user_id'                      => auth()->id(),
                'alias_name'                   => $this->alias_name,
                'social_name'                  => $this->social_name,
                'document_company'             => $this->document_company,
                'document_company_secondary'   => $this->document_company_secondary,
                'cadastur'                     => $this->cadastur,
                'email'                        => $this->email,
                'additional_email'             => $this->additional_email,
                'phone'                        => $this->phone,
                'cell_phone'                   => $this->cell_phone,
                'whatsapp'                     => $this->whatsapp,
                'telegram'                     => $this->telegram,
                'content'                      => $this->content,
                'url'                          => $this->url,
                'zipcode'                      => $this->zipcode,
                'street'                       => $this->street,
                'neighborhood'                 => $this->neighborhood,
                'city'                         => $this->city,
                'state'                        => $this->state,
                'complement'                   => $this->complement,
                'number'                       => $this->number,
                'facebook'                     => $this->facebook,
                'twitter'                      => $this->twitter,
                'instagram'                    => $this->instagram,
                'linkedin'                     => $this->linkedin,
                'tiktok'                       => $this->tiktok,
            ];

            // Criar ou atualizar
            if ($this->company->exists) {
                $this->company->update($data);
            } else {
                $this->company = Company::create($data);
            }

            $folder = 'company/' . $this->company->uuid;

            // Upload logo
            if ($this->logo instanceof TemporaryUploadedFile) {
                if ($this->logoPath) {
                    Storage::disk('public')->delete($this->logoPath);
                }
                $this->logoPath = $this->logo->store($folder, 'public');
                $this->company->update(['logo' => $this->logoPath]);
                $this->logo = null;
            }

            // Upload watermak
            if ($this->metaimg instanceof TemporaryUploadedFile) {
                if ($this->metaimgPath) {
                    Storage::disk('public')->delete($this->metaimgPath);
                }
                $this->metaimgPath = $this->metaimg->store($folder, 'public');
                $this->company->update(['metaimg' => $this->metaimgPath]);
                $this->metaimg = null;
            }        

            // Upload galeria
            if (!empty($this->images)) {
                $this->validate([
                    'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
                ]);

                $maxImages     = config('app.max_images', 20);
                $existingCount = $this->company->images()->count();
                $allowed       = $maxImages - $existingCount;

                if (count($this->images) > $allowed) {
                    $this->dispatch('swal:warning', [
                        'title'             => 'Atenção!',
                        'text'              => "Limite de {$maxImages} imagens atingido.",
                        'icon'              => 'warning',
                        'showConfirmButton' => false,
                    ]);
                    return;
                }

                $manager  = new ImageManager(new Driver());
                $maxOrder = CompanyGb::where('company', $this->company->id)->max('order_img') ?? 0;

                foreach ($this->images as $index => $image) {
                    if ($index >= $allowed) break;

                    $filename = uniqid() . '.webp';
                    $path     = "{$folder}/{$filename}";

                    $img = $manager->read($image->getRealPath())
                        ->scaleDown(width: 1920)
                        ->toWebp(85);

                    Storage::disk('public')->put($path, $img);

                    CompanyGb::create([
                        'company'   => $this->company->id,
                        'path'      => $path,
                        'cover'     => $this->cover ?? null,
                        'order_img' => $maxOrder + $index + 1,
                        'metaimg' => false,
                    ]);
                }

                $this->reset('images');
                $this->savedImages = $this->company->images()->orderBy('order_img')->get();
            }

            $this->dispatch('swal:success', [
                'title'             => 'Sucesso!',
                'text'              => $this->company->wasRecentlyCreated
                    ? 'Empresa cadastrada com sucesso!'
                    : 'Empresa atualizada com sucesso!',
                'timer'             => 2000,
                'showConfirmButton' => false,
            ]);
            

        } catch (ValidationException $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }

        
    }

    public function updatedZipcode(string $value)
    {
        $cep = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cep) === 8) {
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/")->json();

            if (!isset($response['erro'])) {
                $this->street = $response['logradouro'] ?? '';
                $this->neighborhood = $response['bairro'] ?? '';
                $this->state = $response['uf'] ?? '';
                $this->city = $response['localidade'] ?? '';
                //$this->configData['complement'] = $response['complemento'] ?? '';
            } else {
                $this->addError('zipcode', 'CEP não encontrado.'); 
            }
        }
    }

    public function updatedLogo()
    {
        $this->logoPreview = $this->logo->temporaryUrl();
    }

    public function updatedmetaimg()
    {
        $this->metaimgPreview = $this->metaimg->temporaryUrl();
    }

    #[Layout('components.layouts.company', ['title' => 'Dados da Empresa', 'bracrhumb' => 'Gerencie seus dados da empresa.'])]
    public function render()
    {
        return view('livewire.company.company.company-form');
    }
}