<?php

namespace App\Livewire\Dashboard\Tours;

use App\Models\Company;
use App\Models\Tour;
use App\Models\TourGb;
use App\Models\Vessel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TourForm extends Component
{
    use WithFileUploads;

    public ?Tour $tour = null;

    public $vessel_id;
    public $title;
    public $tour_type;
    public $price;
    public $duration;
    public $boarding_place;
    public $description;
    public $rules;
    public $active = true;

    public array $photos = [];

    public ?int $company_id = null;
    public $companies = [];
    public $vessels = [];
    public string $currentTab = 'dados';

    public function mount($tour = null): void
    {
        if ($tour) {
            $this->tour = $tour instanceof Tour ? $tour : Tour::where('uuid', $tour)->firstOrFail();
            $this->authorize('update', $this->tour);

            $this->title          = $this->tour->title;
            $this->tour_type      = $this->tour->tour_type instanceof \App\Enums\TourTypeEnum
                ? $this->tour->tour_type->value
                : $this->tour->tour_type;
            $this->price          = $this->tour->price;
            $this->duration       = $this->tour->duration;
            $this->boarding_place = $this->tour->boarding_place;
            $this->description    = $this->tour->description;
            $this->rules          = $this->tour->rules;
            $this->vessel_id      = $this->tour->vessel_id;
            $this->active         = $this->tour->active;

            if ($this->tour->vessel) {
                $this->company_id = $this->tour->vessel->company_id;
            }

        } else {
            $this->tour = new Tour();
            $this->authorize('create', Tour::class);
        }

        $this->loadCompanies();
        $this->loadVessels();
    }

    protected function loadCompanies(): void
    {
        $this->companies = Company::query()
            ->where('status', true)
            ->orderBy('alias_name')
            ->get();
    }

    protected function loadVessels(): void
    {
        if (!$this->company_id) {
            $this->vessels = [];
            return;
        }

        $this->vessels = Vessel::query()
            ->where('company_id', $this->company_id)
            ->where('active', true)
            ->orderBy('name')
            ->get();
    }

    public function updatedCompanyId(): void
    {
        $this->vessel_id = null;
        $this->loadVessels();
    }

    public function rules(): array
    {
        return [
            'company_id'      => ['required', 'exists:companies,id'],
            'vessel_id'       => ['required', 'exists:vessels,id'],
            'title'           => ['required', 'string', 'min:2', 'max:255'],
            'tour_type'       => ['required', 'in:private,shared'],
            'price'           => ['required', 'numeric', 'min:0'],
            'duration'        => ['required', 'max:100'],
            'boarding_place'  => ['required', 'max:255'],
            'description'     => ['nullable', 'max:5000'],
            'rules'           => ['nullable', 'max:5000'],
            'photos'          => ['nullable', 'array', 'max:20'],
            'photos.*'        => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    protected function messages(): array
    {
        return [
            'company_id.required'     => 'Selecione a operadora.',
            'company_id.exists'       => 'Operadora inválida.',
            'vessel_id.required'      => 'Selecione a embarcação.',
            'vessel_id.exists'        => 'Embarcação inválida.',
            'title.required'          => 'O título do passeio é obrigatório.',
            'title.min'               => 'O título deve ter no mínimo :min caracteres.',
            'title.max'               => 'O título deve ter no máximo :max caracteres.',
            'tour_type.required'      => 'Selecione o tipo do passeio.',
            'tour_type.in'            => 'O tipo do passeio é inválido.',
            'price.required'          => 'Informe o valor do passeio.',
            'price.numeric'           => 'O valor deve ser numérico.',
            'price.min'               => 'O valor informado é inválido.',
            'duration.required'       => 'Informe a duração do passeio.',
            'duration.max'            => 'A duração informada é inválida.',
            'boarding_place.required' => 'Informe o local de embarque.',
            'boarding_place.max'      => 'O local de embarque é inválido.',
            'description.max'         => 'A descrição deve ter no máximo :max caracteres.',
            'photos.array'            => 'Formato de imagens inválido.',
            'photos.max'              => 'Você pode enviar no máximo :max imagens.',
            'photos.*.image'          => 'O arquivo enviado deve ser uma imagem.',
            'photos.*.mimes'          => 'As imagens devem ser JPG, PNG ou WEBP.',
            'photos.*.max'            => 'Cada imagem deve ter no máximo 2MB.',
        ];
    }

    public function save()
    {
        try {
            $this->validate($this->rules(), $this->messages());

            $company = Company::findOrFail($this->company_id);

            $data = [
                'company_id'      => $company->id,
                'vessel_id'       => $this->vessel_id,
                'title'           => $this->title,
                'tour_type'       => $this->tour_type,
                'price'           => $this->price,
                'duration'        => $this->duration,
                'boarding_place'  => $this->boarding_place,
                'description'     => $this->description,
                'rules'           => $this->rules,
                'active'          => $this->active,
            ];

            if ($this->tour?->exists) {
                $this->tour->update($data);
            } else {
                $this->tour = Tour::create($data);
            }

            $folder = 'company/' . $company->uuid . '/tours/' . $this->tour->uuid;

            if (!empty($this->photos)) {
                $this->validate([
                    'photos.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
                ]);

                $maxImages     = config('app.max_images', 20);
                $existingCount = $this->tour->images()->count();
                $allowed       = $maxImages - $existingCount;

                if (count($this->photos) > $allowed) {
                    $this->dispatch('swal:warning', [
                        'title' => 'Atenção!',
                        'text'  => "Limite de {$maxImages} imagens atingido.",
                        'icon'  => 'warning',
                        'showConfirmButton' => false,
                    ]);
                    return;
                }

                $manager  = new ImageManager(new Driver());
                $maxOrder = TourGb::where('tour_id', $this->tour->id)->max('order_img') ?? 0;

                foreach ($this->photos as $index => $image) {
                    if ($index >= $allowed) break;

                    $filename = uniqid() . '.webp';
                    $path     = "{$folder}/{$filename}";

                    $img = $manager->read($image->getRealPath())
                        ->scaleDown(width: 1920)
                        ->toWebp(85);

                    Storage::disk()->put($path, $img);

                    TourGb::create([
                        'tour_id'   => $this->tour->id,
                        'path'      => $path,
                        'cover'     => false,
                        'order_img' => $maxOrder + $index + 1,
                        'watermark' => false,
                    ]);
                }

                $this->reset('photos');
            }

            $this->dispatch('swal:success', [
                'title'             => 'Sucesso!',
                'text'              => $this->tour->wasRecentlyCreated
                    ? 'Passeio cadastrado com sucesso!'
                    : 'Passeio atualizado com sucesso!',
                'timer'             => 2000,
                'showConfirmButton' => false,
            ]);

            if ($this->tour->wasRecentlyCreated) {
                return redirect()->route('admin.tours.edit', $this->tour);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('scroll-to-first-error');
            throw $e;
        }
    }

    public function setCover($id)
    {
        $this->tour->images()->update(['cover' => false]);
        TourGb::where('id', $id)->update(['cover' => true]);
        $this->tour->refresh();
    }

    public function deleteImage($id): void
    {
        $image = TourGb::findOrFail($id);
        Storage::disk()->delete($image->path);
        $image->delete();
        $this->tour->refresh();
    }

    public function removePhoto($index)
    {
        unset($this->photos[$index]);
        $this->photos = array_values($this->photos);
    }

    public function updatedPhotos(): void
    {
        $hasHeic = collect($this->photos)->contains(function ($photo) {
            return strtolower($photo->getClientOriginalExtension()) === 'heic';
        });

        if ($hasHeic) {
            $this->dispatch('swal:warning', [
                'title' => 'Formato não suportado!',
                'text'  => 'Imagens no formato HEIC (iPhone) não são aceitas.',
                'icon'  => 'warning',
            ]);

            $this->reset('photos');
        }
    }

    public function updateImageOrder(array $order): void
    {
        foreach ($order as $item) {
            TourGb::where('id', $item['id'])->update(['order_img' => $item['position']]);
        }
    }

    public function render()
    {
        $title = $this->tour->exists ? 'Editar Passeio' : 'Cadastrar Passeio';

        if (empty($this->companies)) {
            $this->loadCompanies();
        }

        if (empty($this->vessels) && $this->company_id) {
            $this->loadVessels();
        }

        return view('livewire.dashboard.tours.tour-form')->with([
            'title'     => $title,
            'companies' => $this->companies,
            'vessels'   => $this->vessels,
        ]);
    }
}
