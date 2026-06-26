<?php

namespace App\Livewire\Web;

use App\Models\Company;
use App\Models\Tour;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;

class SearchDropdown extends Component
{
    
    public string $search = '';

    public bool $open = false;

    public function mount()
    {
        
    }

    #[Computed]
    public function results(): array
    {
        $term = trim($this->search);

        // Inicializa sempre com coleções vazias para evitar o erro de 'null'
        $default = [
            'cities' => collect(),
            'companies' => collect(),
            'tours' => collect(),
        ];

        if (strlen($term) < 2) {
            return $default;
        }

        $cities = Company::query()
            ->where('status', true)
            ->whereHas('tours', fn ($q) => $q->where('active', true))
            ->where('city', 'like', "%{$term}%")
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->limit(5)
            ->pluck('city');

        $companies = Company::query()
            ->select('id', 'alias_name', 'slug', 'city', 'logo')
            ->where('status', true)
            ->where('alias_name', 'like', "%{$term}%")
            ->limit(5)
            ->get();

        $tours = Tour::query()
        ->with('company:id,alias_name,slug')
        ->select(
            'id',
            'uuid',
            'company_id',
            'title',
            'slug'
        )
        ->where('active', true)
        ->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%");
        })
        ->limit(5)
        ->get();

        return [
            'cities' => $cities,
            'companies' => $companies,
            'tours' => $tours,
        ];
    }

    public function updatedSearch()
    {
        $this->open = strlen(trim($this->search)) >= 2;
    }

    public function close()
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.web.search-dropdown');
    }
}
