<?php

namespace App\Livewire\Company\Tours;

use App\Models\Tour;
use App\Models\TourGb;
use App\Models\Vessel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TourForm extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public ?Tour $tour = null;

    public array $photos = [];
    public $savedImages = [];

    public $vessel_id;

    public $title;

    public $tour_type;

    public $price;

    public $duration;

    public $boarding_place;

    public $description;

    public $rules;

    public $active = true;

    public $images = [];

    public function mount(?Tour $tour = null)
    {
        if ($tour?->exists) {

            $this->tour = $tour;

            $this->fill($tour->only([
                'vessel_id',
                'title',
                'tour_type',
                'price',
                'duration',
                'boarding_place',
                'description',
                'rules',
                'active',
            ]));
        }
    }

    protected function rules(): array
    {
        return [
            'title' => ['required','string','min:2','max:255',],
            'tour_type' => ['required'],
            'price' => ['required','numeric','min:0',],
            'duration' => ['required','max:100',],
            'boarding_place' => ['required','max:255',],
            'description' => ['nullable',],
            'rules' => ['nullable',],
            
            'photos' => ['nullable','array','max:20',],
            'photos.*' => ['image','mimes:jpg,jpeg,png,webp','max:2048',],
        ];
    }

    protected function messages(): array
    {
        return [

            'title.required' => 'O título do passeio é obrigatório.',
            'title.min' => 'O título deve ter no mínimo :min caracteres.',
            'title.max' => 'O título deve ter no máximo :max caracteres.',

            'tour_type.required' => 'Selecione o tipo do passeio.',
            'tour_type.max' => 'O tipo do passeio é inválido.',

            'price.required' => 'Informe o valor do passeio.',
            'price.numeric' => 'O valor deve ser numérico.',
            'price.min' => 'O valor informado é inválido.',

            'duration.required' => 'Informe a duração do passeio.',
            'duration.max' => 'A duração informada é inválida.',

            'boarding_place.required' => 'Informe o local de embarque.',
            'boarding_place.max' => 'O local de embarque é inválido.',

            'description.max' => 'A descrição deve ter no máximo :max caracteres.',

            'photos.array' => 'Formato de imagens inválido.',
            'photos.max' => 'Você pode enviar no máximo :max imagens.',

            'photos.*.image' => 'O arquivo enviado deve ser uma imagem.',
            'photos.*.mimes' => 'As imagens devem ser JPG, PNG ou WEBP.',
            'photos.*.max' => 'Cada imagem deve ter no máximo 2MB.',

        ];
    }

    public function save()
    {
        try {
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
                'company_id' => Auth::guard('customer')->user()->company->id,
                'vessel_id' => $this->vessel_id,  
                'title' => $this->title,
                'tour_type' => $this->tour_type,
                'price' => $this->price,
                'duration' => $this->duration,
                'boarding_place' => $this->boarding_place,
                'description' => $this->description,
                'rules' => $this->rules,
                'active' => $this->active,
            ];        

            // Criar ou atualizar
            if ($this->tour?->exists) {
                $this->authorize('update', $this->tour);
                $this->tour->update($data);
            } else {
                $this->authorize('create', Tour::class);
                $this->tour = Tour::create($data);
            }

            $folder = 'company/' . $company->uuid . '/tours/' . $this->tour->uuid;

            // Upload galeria
            if (!empty($this->photos)) {
                $this->validate([
                    'photos.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
                ]);

                $maxImages     = config('app.max_images', 20);
                $existingCount = $this->tour->images()->count();
                $allowed       = $maxImages - $existingCount;

                if (count($this->photos) > $allowed) {
                    $this->dispatch('swal:warning', [
                        'title'             => 'Atenção!',
                        'text'              => "Limite de {$maxImages} imagens atingido.",
                        'icon'              => 'warning',
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

                    Storage::disk('public')->put($path, $img);

                    TourGb::create([
                        'tour_id'   => $this->tour->id,
                        'path'      => $path,
                        'cover'     => $this->cover ?? null,
                        'order_img' => $maxOrder + $index + 1,
                        'watermark' => false,
                    ]);
                }

                $this->reset('photos');
                $this->savedImages = $this->tour->images()->orderBy('order_img')->get();
            }

            $this->dispatch('swal:success', [
                'title'             => 'Sucesso!',
                'text'              => $this->tour->wasRecentlyCreated
                    ? 'Passeio cadastrado com sucesso!'
                    : 'Passeio atualizado com sucesso!',
                'timer'             => 2000,
                'showConfirmButton' => false,
            ]);
        } catch (ValidationException $e) {
            $this->dispatch('scroll-to-error');
            //dd($e);
            throw $e;
        }
    }

    public function setCover($id)
    {
        $this->authorize('update', $this->tour);
        $this->tour->images()->update(['cover' => false]);
        TourGb::where('id', $id)->update(['cover' => true]);
    }

    public function deleteImage($id): void
    {
        $image = TourGb::findOrFail($id);
        $this->authorize('update', $this->tour);
        Storage::disk('public')->delete($image->path);
        $image->delete();

        $this->savedImages = $this->tour
            ->images()
            ->orderBy('order_img')
            ->get();

        $this->dispatch('swal:success', [
            'title' => 'Imagem removida!',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }    

    public function removePhoto($index)
    {
        unset($this->photos[$index]);

        $this->photos = array_values($this->photos);
    }

    #[Layout('components.layouts.company')]
    public function render()
    {
        return view('livewire.company.tours.tour-form', [
            'vessels' => Vessel::query()
                ->where('company_id', Auth::guard('customer')->user()->company->id)
                ->where('active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }
}
