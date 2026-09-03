<?php

namespace App\Livewire\Dashboard\Vessels;

use App\Models\Company;
use App\Models\Vessel;
use App\Models\VesselGb;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class VesselForm extends Component
{
    use WithFileUploads;

    public ?Vessel $vessel = null; 

    public ?int $company_id = null;
    public $companies = [];

    public string $currentTab = 'dados'; 

    public array $images = [];
    public $savedImages = [];  

    public ?string $name;
    public ?string $type;
    public ?int $capacity;
    public ?int $year;
    public ?int $size;
    public ?string $description;
    public ?int $bathroom;
    public ?bool $barbecue;
    public ?bool $suite;
    public ?bool $sound_system;
    public ?bool $kitchen; 

    public ?int $display_marked_water = 0; // 0 = Não, 1 = Sim

    protected function rules(): array
    {
        return [
            'name' => ['required','string','min:2','max:255',],
            'type' => ['required','string','max:100',],
            'capacity' => ['required','integer','min:1','max:999',],
            'year' => ['nullable','integer','min:1900','max:' . now()->year,],
            'size' => ['nullable','integer','min:2','max:100',],
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

    public function mount($id = null): void
    {
        if ($id) {
            $this->vessel = Vessel::findOrFail($id);
            $this->authorize('update', $this->vessel);
            $this->fill($this->vessel->toArray());
        } else {
            $this->vessel = new Vessel();
            $this->authorize('create', Vessel::class);
        }

        $this->companies = Company::query()
            ->where(function ($query) {
                $query->where('status', true);

                if ($this->company_id) {
                    $query->orWhere('id', $this->company_id);
                }
            })
            ->orderBy('alias_name')
            ->get();
    }

    public function save(string $mode = 'draft')
    {
        // 🔹 Regras dinâmicas
        $rules = $this->rules();       

        // 🔹 Validação
        $validated = $this->validate($rules);

        // 🔹 Ajustes
        $validated['active']   = $mode === 'published' ? 1 : 0;

        // 🔹 Monta payload
        $data = [
            'name' => $validated['name'],
            'company_id' => $this->company_id,
            'type' => $this->type,
            'capacity' => $this->capacity,
            'year' => $this->year,
            'size' => $this->size,
            'description' => $this->description,
            'bathroom' => $this->bathroom,
            'barbecue' => $this->barbecue,
            'suite' => $this->suite,
            'sound_system' => $this->sound_system,
            'kitchen' => $this->kitchen,
        ];        

        // 🔹 Create ou Update
        if ($this->vessel->exists) {
            $this->vessel->update($data);
        } else {
            $this->vessel = Vessel::create($data);
            $this->vessel->load([
                'company',
                'images'
            ]);
        }

        // 🔹 Agora já tem ID
        $folder = 'companies/' . $this->vessel->company->uuid . '/vessels/' . $this->vessel->id;
       
        // 🔹 Validação imagens múltiplas
        $this->validate([
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $maxImages = config('app.max_images');
        $existingImages = $this->vessel->images()->count();
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

        $manager = new ImageManager(new Driver());

        foreach ($this->images as $index => $image) {

            if ($index >= $allowed) break;

            $filename = uniqid() . '.webp';
            $path = "{$folder}/{$filename}";

            $img = $manager->read($image->getRealPath())
                ->scaleDown(width: 1920)
                ->toWebp(85);

            Storage::disk('r2')->put($path, $img);

            $maxOrder = VesselGb::where('vessel_id', $this->vessel->id)->max('order_img') ?? 0;

            VesselGb::create([
                'vessel_id' => $this->vessel->id,
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
            'text' => $this->vessel->wasRecentlyCreated
                ? 'Embarcação cadastrada com sucesso!'
                : 'Embarcação atualizada com sucesso!',
            'timer' => 2000,
            'showConfirmButton' => false
        ]);

        // 🔹 Redirect
        if ($this->vessel->wasRecentlyCreated) {
            return redirect()->route('vessels.edit', $this->vessel);
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
        $image = VesselGb::find($id);
        if ($image) {
            Storage::disk('r2')->delete($image->path);
            $image->delete();
            $this->savedImages = collect($this->savedImages)->filter(fn ($img) => $img->id !== $id);
            $this->vessel->refresh(); // Para garantir que os dados estejam atualizados
        }
    }

    public function toggleCover($imageId)
    {
        $image = VesselGb::where('id', $imageId)->where('vessel_id', $this->vessel->id)->first();

        if ($image) {
            if ($image->cover) {
                // Se já é capa, remove
                $image->update(['cover' => 0]);
            } else {
                // Remove capa das outras e define esta
                VesselGb::where('vessel_id', $this->vessel->id)->update(['cover' => 0]);
                $image->update(['cover' => 1]);
            }

            // Atualiza a relação para refletir na view
            $this->vessel->refresh();
        }
    }

    #[On('updateDescription')]
    public function updateDescription($value)
    {
        $this->description = $value;
    }

    public function updateImageOrder($order)
    {
        try {
            foreach ($order as $item) {
                VesselGb::where('id', $item['id'])
                    ->where('vessel_id', $this->vessel->id)
                    ->update(['order_img' => $item['position']]);
            }
            
            // Atualiza a propriedade para refletir a nova ordem
            $this->vessel->refresh();
            
        } catch (\Exception $e) {
            $this->toastError('Erro ao atualizar ordem das imagens: ' . $e->getMessage());
        }
    }

    public function applyWatermarkImage($imageId)
    {
        $image = VesselGb::find($imageId);

        if ($image->watermark) {
            return;
        }

        $manager = new ImageManager(new Driver());

        $img = $manager->read(storage_path('app/public/'.$image->path));
        $watermark = $manager->read(storage_path('app/public/'. $this->vessel->company->watermark));

        $img->place($watermark, 'bottom-right', 30, 30);
        $img->save();

        $image->update([
            'watermark' => true
        ]);

        $this->dispatch('swal:success', [
            'title' => false,
            'text' => 'Marca d’água aplicada!',
            'timer' => 2000,
            'showConfirmButton' => false
        ]);
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

    public function render()
    {
        $title = $this->vessel->exists ? 'Editar Embarcação' : 'Cadastrar Embarcação';
        return view('livewire.dashboard.vessels.vessel-form')->with('title', $title);
    }
}
