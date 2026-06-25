<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class CustomerLogin extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected $rules = [
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required'    => 'O e-mail é obrigatório.',
        'email.email'       => 'Informe um e-mail válido.',
        'password.required' => 'A senha é obrigatória.',
        'password.min'      => 'A senha deve ter no mínimo 6 caracteres.',
    ];

    public function login(): void
    {
        $this->validate();

        $credentials = [
            'email'    => $this->email,
            'password' => $this->password,
        ];

        if (!Auth::guard('customer')->attempt($credentials, $this->remember)) {
            $this->addError('email', 'E-mail ou senha incorretos.');
            return;
        }

        $customer = Auth::guard('customer')->user();

        if (!$customer->hasRole('proprietary')) {
            Auth::guard('customer')->logout();
            $this->addError('email', 'Acesso não autorizado.');
            return;
        }

        if (!$customer->status) {
            Auth::guard('customer')->logout();
            $this->addError('email', 'Sua conta está inativa. Entre em contato com o suporte.');
            return;
        }

        session()->regenerate();

        redirect()->intended(route('company.dashboard'));
    }

    #[Layout('components.layouts.guest', ['title' => 'Login Painel'])]
    public function render()
    {
        return view('livewire.auth.customer-login');
    }
}
