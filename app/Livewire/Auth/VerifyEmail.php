<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;


class VerifyEmail extends Component
{
    public function resend()
    {
        auth()->user()->sendEmailVerificationNotification();

        session()->flash(
            'success',
            'Novo link enviado.'
        );
    }

    #[Layout('web.client.create', ['title' => 'Verifique seu email'])]    
    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}