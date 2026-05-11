<?php

namespace App\Livewire\Company;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{
    #[Layout('components.layouts.company')]
    public function render()
    {
        return view('livewire.company.dashboard')->with('title', 'Dashboard');
    }
}
