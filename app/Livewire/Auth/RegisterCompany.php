<?php

namespace App\Livewire\Auth;

use App\Models\Customer;
use App\Models\User;
use App\Notifications\NewCompanyRegistered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RegisterCompany extends Component
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $cell_phone = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;

    public bool $aceite_termos = false;
    public bool $aceite_privacidade = false;

    protected function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', 'unique:customers,email'],
            'cell_phone'        => ['required', 'string', 'max:20'],
            'password'          => ['required', 'confirmed', 'min:6'],
            'aceite_termos'     => ['accepted'],
            'aceite_privacidade' => ['accepted'],
        ];
    }

    protected $messages = [
        'name.required'              => 'Informe seu nome.',
        'email.required'             => 'Informe seu email.',
        'email.email'                => 'Informe um email válido.',
        'email.unique'               => 'Este email já está em uso.',
        'cell_phone.required'        => 'Informe seu telefone.',
        'password.required'          => 'Informe uma senha.',
        'password.confirmed'         => 'As senhas não conferem.',
        'password.min'               => 'A senha deve ter pelo menos 6 caracteres.',
        'aceite_termos.accepted'     => 'Você precisa aceitar os Termos de Uso.',
        'aceite_privacidade.accepted' => 'Você precisa aceitar a Política de Privacidade.',
    ];

    public function save()
    {
        $validated = $this->validate();

        DB::transaction(function () use ($validated) {

            $customer = Customer::create([
                'name'       => $validated['name'],
                'email'      => $validated['email'],
                'cell_phone' => $validated['cell_phone'],
                'password'   => Hash::make($validated['password']),
                'status'     => true,
            ]);

            $customer->assignRole('proprietary');

            Auth::guard('customer')->login($customer);

            Notification::send(
                User::role(['admin', 'manager', 'super-admin'])->get(),
                new NewCompanyRegistered($customer)
            );
        });

        session()->flash('success', 'Cadastro realizado com sucesso!');

        return redirect()->route('company.dashboard');
    }

    #[Layout('web.client.create', ['title' => 'Cadastro de Empresa'])]
    public function render()
    {
        return view('livewire.auth.register-company');
    }
}