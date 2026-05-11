<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Notifications\WelcomeCompanyNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class RegisterCompany extends Component
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $cell_phone = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;

    protected function rules()
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],

            'cell_phone' => [
                'required',
                'string',
                'max:20'
            ],

            'password' => [
                'required',
                'confirmed',
                'min:6'
            ],
        ];
    }

    protected $messages = [

        'name.required' => 'Informe seu nome.',
        'email.required' => 'Informe seu email.',
        'email.email' => 'Informe um email válido.',
        'email.unique' => 'Este email já está em uso.',

        'cell_phone.required' => 'Informe seu telefone.',

        'password.required' => 'Informe uma senha.',
        'password.confirmed' => 'As senhas não conferem.',
        'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
    ];

    public function save()
    {
        $validated = $this->validate();

        DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'cell_phone' => $validated['cell_phone'],
                'password' => Hash::make(
                    $validated['password']
                ),
                'status' => 1,
            ]);

            $user->assignRole('company');

            Auth::login($user);

            $user->sendEmailVerificationNotification();            
        });

        session()->flash(
            'success',
            'Cadastro realizado com sucesso! Verifique seu email.'
        );

        return redirect()->route('verification.notice');
    }

    #[Layout('web.client.create', ['title' => 'Cadastro de Empresa'])]
    public function render()
    {
        return view('livewire.auth.register-company');
    }
}
