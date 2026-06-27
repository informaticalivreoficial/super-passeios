<?php

namespace App\Livewire\Dashboard\Tours;

use App\Models\Tour;
use Livewire\Component;
use Livewire\WithFileUploads;

class TourForm extends Component
{
    use WithFileUploads;

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

    public function mount($id = null): void
    {
        if ($id) {
            $this->authorize('update', $this->tour);
        }else{
            $this->tour = new Tour();
            $this->authorize('create', Tour::class);
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

    public function render()
    {
        $title = $this->tour->exists ? 'Editar Passeio' : 'Cadastrar Passeio';
        return view('livewire.dashboard.tours.tour-form')->with('title', $title);
    }
}
