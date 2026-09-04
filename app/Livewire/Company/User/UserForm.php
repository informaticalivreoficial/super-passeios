<?php

namespace App\Livewire\Company\User;

use App\Models\Customer;
use App\Services\ViaCepService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Validation\ValidationException;

class UserForm extends Component
{
    use WithFileUploads;

    public ?Customer $customer = null;

    public $customerId;

    // pessoais
    public $gender;
    public $name;
    public $birthday;
    public $civil_status;

    // docs
    public $cpf;
    public $rg;
    public $naturalness;

    // contatos
    public $phone;
    public $cell_phone;
    public $whatsapp;
    public $email;
    public $additional_email;
    public $telegram;

    // endereço
    public $zipcode = '';
    public $street;
    public $neighborhood;
    public $city;
    public $state;
    public $complement;
    public $number;

    // avatar
    public $avatar;
    public $avatarPreview;

    // Social
    public $facebook, $instagram, $linkedin, $twitter;

    // senha
    public $password;
    public $password_confirmation;

    protected function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            //'email'     => ['required', 'email', Rule::unique('customers', 'email')->ignore($this->customerId)],
            'cpf'       => ['nullable', Rule::unique('customers', 'cpf')->ignore($this->customerId)],
            'avatar'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'password'  => ['nullable', 'confirmed', Password::min(6)],
            'birthday'     => 'required|date_format:d/m/Y',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required'      => 'Informe seu nome.',
            //'email.required'     => 'Informe o e-mail.',
            //'email.email'        => 'Informe um e-mail válido.',
            //'email.unique'       => 'Este e-mail já está em uso.',
            'cpf.required'       => 'Informe o CPF.',
            'cpf.cpf'            => 'Informe um CPF válido.',
            'cpf.min'            => 'Informe um CPF valido.',
            'cpf.max'            => 'Informe um CPF valido.',
            'birthday.required'  => 'Informe a data de nascimento.',
            'birthday.date_format' => 'Informe uma data válida.',
            'cpf.unique'         => 'Este cpfo já está cadastrado.',
            'avatar.image'       => 'O arquivo deve ser uma imagem.',
            'avatar.max'         => 'A imagem deve ter no máximo 2MB.',
            'password.confirmed' => 'As senhas não conferem.',
        ];
    }

    public function mount($customerId = null): void
    {
        if ($customerId) {
            $this->customer = Customer::findOrFail($customerId);
            $this->authorize('update', $this->customer);
        } else {
            $this->customer = Auth::guard('customer')->user();
        }

        $this->customerId = $this->customer->id;

        $this->fill(
            $this->customer->only([
                'gender',
                'name',
                'birthday',
                'civil_status',
                'cpf',
                'rg',
                'naturalness',
                'phone',
                'cell_phone',
                'whatsapp',
                'email',
                'additional_email',
                'telegram',
                'zipcode',
                'street',
                'neighborhood',
                'city',
                'state',
                'complement',
                'number',
                'facebook', 'instagram', 'linkedin', 'twitter',
            ])
        );

        $this->avatarPreview = $this->customer->avatar
            ? Storage::url($this->customer->avatar)
            : null;
    }

    public function updatedAvatar(): void
    {
        $this->validateOnly('avatar');
        $this->avatarPreview = $this->avatar->temporaryUrl();
    }

    public function removeAvatar(): void
    {
        $this->avatar = null;
        $this->avatarPreview = $this->customer?->avatar
            ? Storage::url($this->customer->avatar)
            : null;
    }

    public function save(): void
    {
        try {
            $avatarSnapshot = $this->avatar;
            $this->validate($this->rules(), $this->messages());

            $data = [
                'gender'           => $this->gender,
                'name'             => $this->name,
                'birthday'         => $this->birthday,
                'civil_status'     => $this->civil_status,
                'cpf'              => $this->cpf,
                'rg'               => $this->rg,
                'naturalness'      => $this->naturalness,
                'phone'            => $this->phone,
                'cell_phone'       => $this->cell_phone,
                'whatsapp'         => $this->whatsapp,
                //'email'            => $this->email,
                'additional_email' => $this->additional_email,
                'telegram'         => $this->telegram,
                'zipcode'          => $this->zipcode,
                'street'           => $this->street,
                'neighborhood'     => $this->neighborhood,
                'city'             => $this->city,
                'state'            => $this->state,
                'complement'       => $this->complement,
                'number'           => $this->number,
                'facebook'         => $this->facebook,
                'instagram'        => $this->instagram,
                'linkedin'         => $this->linkedin,
                'twitter'          => $this->twitter,
            ];

            if ($avatarSnapshot) {
                if ($this->customer?->avatar) {
                    Storage::disk()->delete($this->customer->avatar);
                }

                $data['avatar'] = $avatarSnapshot->store(
                    'company/' . $this->customer->company->uuid . '/customers',
                    'public'
                );
            }

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            $this->customer->update($data);

            $this->dispatch('swal:success', [
                'title' => 'Sucesso',
                'text'  => 'Conta atualizada com sucesso.',
            ]);

        } catch (ValidationException $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }
    }

    public function updatedZipcode(
        string $value,
        ViaCepService $viaCep
    ) {
        $data = $viaCep->find($value);

        if (!$data) {
            $this->addError('zipcode', 'CEP não encontrado.');
            return;
        }

        $this->street       = $data['logradouro'] ?? '';
        $this->neighborhood = $data['bairro'] ?? '';
        $this->city         = $data['localidade'] ?? '';
        $this->state        = $data['uf'] ?? '';
        $this->complement   = $data['complemento'] ?? '';
    }

    #[Layout('components.layouts.company', ['title' => 'Minha Conta', 'bracrhumb' => 'Gerencie seus dados pessoais.'])]
    public function render()
    {
        return view('livewire.company.user.user-form');
    }
}