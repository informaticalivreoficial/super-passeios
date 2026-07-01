<?php

namespace App\Livewire\Web;

use App\Models\Newsletter;
use Livewire\Component;

class NewsletterForm extends Component
{
    public string $email = '';
    public bool $success = false;

    protected $rules = [
        'email' => 'required|email|unique:newsletters,email',
    ];

    protected $messages = [
        'email.required' => 'Informe seu e-mail.',
        'email.email'    => 'Informe um e-mail válido.',
        'email.unique'   => 'Este e-mail já está inscrito.',
    ];

    public function subscribe(): void
    {
        $this->validate();

        Newsletter::create([
            'email'              => $this->email,
            'unsubscribe_token'  => \Illuminate\Support\Str::random(64),
        ]);

        $this->reset('email');
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.web.newsletter-form');
    }
}
