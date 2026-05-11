<?php

namespace App\Livewire\Company\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

class UserForm extends Component
{
    #[Layout('components.layouts.company', ['title' => 'Minha Conta'])]
    public function render()
    {
        return view('livewire.company.user.user-form');
    }
}
