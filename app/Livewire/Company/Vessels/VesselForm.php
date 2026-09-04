<?php

namespace App\Livewire\Company\Vessels;

use App\Models\Vessel;
use App\Models\VesselGb;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VesselForm extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public ?Vessel $vessel = null;

    // Imagens
    public array $images = [];
    public $savedImages = []; 
    public $existingImages = [];

    public bool $active;

    public ?string $name = null;
    public ?string $type = null;
    public ?int $capacity = null;
    public ?int $year = null;
    public ?int $size = null;
    public ?string $description = null;
    public ?int $bathroom = null;

    public bool $barbecue = false;
    public bool $suite = false;
    public bool $sound_system = false;
    public bool $display_marked_water = false;
    public bool $kitchen = false;   

    public function mount(?Vessel $vessel = null): void
    {
        if ($vessel && $vessel->exists) {
            $this->authorize('update', $vessel);
            $this->vessel = $vessel;
            $this->fillForm();
            
            $this->savedImages = $this->vessel
                ->images()
                ->orderBy('order_img')
                ->get();
        } else {
            $this->authorize('create', Vessel::class);
            $this->vessel = new Vessel();
        }
    }

    private function fillForm(): void
    {
        $c = $this->vessel;

        $this->name = $c->name;
        $this->type = $c->type;
        $this->capacity = $c->capacity;
        $this->year = $c->year;
        $this->size = $c->size;
        $this->description = $c->description;
        $this->bathroom = $c->bathroom;

        $this->barbecue = (bool) $c->barbecue;
        $this->suite = (bool) $c->suite;
        $this->sound_system = (bool) $c->sound_system;
        $this->display_marked_water = (bool) $c->display_marked_water;
        $this->kitchen = (bool) $c->kitchen;
        $this->active = (bool) $c->active;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required','string','min:2','max:255',],
            'type' => ['required','string','max:100',],
            'capacity' => ['required','integer','min:1','max:999',],
            'year' => ['nullable','integer','min:1900','max:' . now()->year,],
            'size' => ['nullable','numeric','min:1','max:999',],
            'bathroom' => ['nullable','integer','min:0','max:50',],
            'description' => ['nullable','string','max:5000',],
            
            'barbecue' => ['boolean',],
            'suite' => ['boolean',],
            'sound_system' => ['boolean',],
            'display_marked_water' => ['boolean',],
            'kitchen' => ['boolean',],
            
            'images' => ['nullable','array','max:20',],
            'images.*' => ['image','mimes:jpg,jpeg,png,webp','max:2048',],
        ];
    }

    protected function messages(): array
    {
        return [

            'name.required' => 'O nome da embarcação é obrigatório.',
            'name.min' => 'O nome deve ter no mínimo :min caracteres.',
            'name.max' => 'O nome deve ter no máximo :max caracteres.',

            'type.required' => 'Selecione o tipo da embarcação.',
            'type.max' => 'O tipo da embarcação é inválido.',

            'capacity.required' => 'Informe a capacidade da embarcação.',
            'capacity.integer' => 'A capacidade deve ser um número inteiro.',
            'capacity.min' => 'A capacidade mínima é :min pessoa.',
            'capacity.max' => 'A capacidade informada é inválida.',

            'year.integer' => 'O ano deve ser um número válido.',
            'year.min' => 'O ano informado é inválido.',
            'year.max' => 'O ano não pode ser maior que :max.',

            'size.numeric' => 'O tamanho deve ser numérico.',
            'size.min' => 'O tamanho mínimo é :min metro.',
            'size.max' => 'O tamanho informado é inválido.',

            'bathroom.integer' => 'A quantidade de banheiros deve ser um número.',
            'bathroom.min' => 'A quantidade mínima de banheiros é :min.',
            'bathroom.max' => 'Quantidade de banheiros inválida.',

            'description.max' => 'A descrição deve ter no máximo :max caracteres.',

            'images.array' => 'Formato de imagens inválido.',
            'images.max' => 'Você pode enviar no máximo :max imagens.',

            'images.*.image' => 'O arquivo enviado deve ser uma imagem.',
            'images.*.mimes' => 'As imagens devem ser JPG, PNG ou WEBP.',
            'images.*.max' => 'Cada imagem deve ter no máximo 2MB.',

        ];
    }

    public function save(): void
    {
        try {                  

            $imagesSnapshot = $this->images;

            $this->validate($this->rules(), $this->messages());
    
            $company = Auth::guard('customer')->user()->company;

            if (!$company) {
                $this->dispatch('swal:error', [
                    'title' => 'Erro!',
                    'text'  => 'Você precisa cadastrar uma empresa antes.',
                ]);
                return;
            }

            $data = [
                'company_id'             => $company->id,
                'name'                   => $this->name,
                'type'                   => $this->type,
                'capacity'               => $this->capacity,
                'year'                   => $this->year,
                'size'                   => $this->size,
                'description'            => $this->description,
                'active'                 => $this->active ?? 0,

                'bathroom'               => $this->bathroom ?: 0,
                'barbecue'               => $this->barbecue ?: 0,
                'suite'                  => $this->suite ?: 0,
                'sound_system'           => $this->sound_system ?: 0,
                'display_marked_water'   => $this->display_marked_water ?: 0,
                'kitchen'                => $this->kitchen ?: 0,                
            ];

            // Criar ou atualizar
            if ($this->vessel->exists) {
                $this->authorize('update', $this->vessel);
                $this->vessel->update($data);
            } else {
                $this->authorize('create', Vessel::class);
                $this->vessel = Vessel::create($data);
            }

            $folder = 'company/' . $company->uuid . '/vessels/' . $this->vessel->uuid;                  

            // Upload galeria
            if (!empty($imagesSnapshot)) {
                $this->validate([
                    'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
                ]);

                $maxImages     = config('app.max_images', 20);
                $existingCount = $this->vessel->images()->count();
                $allowed       = $maxImages - $existingCount;

                if (count($imagesSnapshot) > $allowed) {
                    $this->dispatch('swal:warning', [
                        'title'             => 'Atenção!',
                        'text'              => "Limite de {$maxImages} imagens atingido.",
                        'icon'              => 'warning',
                        'showConfirmButton' => false,
                    ]);
                    return;
                }

                $manager  = new ImageManager(new Driver());
                $maxOrder = VesselGb::where('vessel_id', $this->vessel->id)->max('order_img') ?? 0;

                foreach ($imagesSnapshot as $index => $image) {
                    if ($index >= $allowed) break;

                    $filename = uniqid() . '.webp';
                    $path     = "{$folder}/{$filename}";

                    $img = $manager->read($image->getRealPath())
                        ->scaleDown(width: 1920)
                        ->toWebp(85);

                    Storage::disk()->put($path, $img);

                    VesselGb::create([
                        'vessel_id'   => $this->vessel->id,
                        'path'      => $path,
                        'cover'     => $this->cover ?? null,
                        'order_img' => $maxOrder + $index + 1,
                        'watermark' => false,
                    ]);
                }

                $this->reset('images');
                $this->savedImages = $this->vessel->images()->orderBy('order_img')->get();
            }

            $this->dispatch('swal:success', [
                'title'             => 'Sucesso!',
                'text'              => $this->vessel->wasRecentlyCreated
                    ? 'Embarcação cadastrada com sucesso!'
                    : 'Embarcação atualizada com sucesso!',
                'timer'             => 2000,
                'showConfirmButton' => false,
            ]);
            

        } catch (ValidationException $e) {
            $this->dispatch('scroll-to-error');
            //dd($e);
            throw $e;
        }
    }

    public function deleteImage($id): void
    {
        $image = VesselGb::findOrFail($id);

        $this->authorize('update', $this->vessel);

        Storage::disk()->delete($image->path);

        $image->delete();

        $this->savedImages = $this->vessel
            ->images()
            ->orderBy('order_img')
            ->get();

        $this->dispatch('swal:success', [
            'title' => 'Imagem removida!',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function setCover($id): void
    {
        $this->authorize('update', $this->vessel);

        VesselGb::where('vessel_id', $this->vessel->id)->update(['cover' => false]);

        VesselGb::where('id', $id)->update(['cover' => true]);

        $this->savedImages = $this->vessel
            ->images()
            ->orderBy('order_img')
            ->get();

        $this->dispatch('swal:success', [
            'title' => 'Capa atualizada!',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function removeTempImage($index)
    {
        unset($this->images[$index]);

        $this->images = array_values($this->images);
    }

    #[Layout('components.layouts.company')]
    public function render()
    {
        $title = $this->vessel?->exists
            ? 'Editar Embarcação'
            : 'Nova Embarcação';

        return view('livewire.company.vessels.vessel-form', compact('title'));
    }
}
