<?php

namespace App\Livewire\Dashboard;

use App\Models\Company;
use App\Models\Post;
use Livewire\Component;
use App\Traits\WithToastr;

class Dashboard extends Component
{
    use WithToastr;
    
    public $topcompanies = [];

    public function render()
    {        
        $this->authorize('viewAny', Company::class);

        $noticiasCount = Post::where('type', 'noticia')->count();
        $noticiasYearCount = Post::where('type', 'noticia')->whereYear('created_at', now()->year)->count();

        $articlesCount = Post::where('type', 'artigo')->count();
        $articlesYearCount = Post::where('type', 'artigo')->whereYear('created_at', now()->year)->count();
        
        $companyCount = Company::count();
        $companyYearCount = Company::whereYear('created_at', now()->year)->count();
        

        $title = 'Painel de Controle';

        return view('livewire.dashboard.dashboard', [
            'title' => $title, 
            'noticiasCount' => $noticiasCount,
            'noticiasYearCount' => $noticiasYearCount,
            'articlesCount' => $articlesCount,
            'articlesYearCount' => $articlesYearCount,
            'companyCount' => $companyCount,
            'companyYearCount' => $companyYearCount
        ]);
    }
}
