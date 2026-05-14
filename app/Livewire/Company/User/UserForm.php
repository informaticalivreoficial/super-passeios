<?php

namespace App\Livewire\Company\User;

use App\Models\User;
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

    public ?User $user = null;

    public $userId;

    // pessoais
    public $gender;
    public $name;
    public $cargo;
    public $birthday;
    public $naturalness;
    public $civil_status;
    //public $information;

    // docs
    public $cpf;
    public $rg;
    public $rg_expedition;

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

    // redes
    public $facebook;
    public $instagram;
    public $linkedin;
    public $twitter;

    // avatar
    public $avatar;
    public $avatarPreview;

    // senha
    public $password;
    public $password_confirmation;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId),],
            'cpf' => ['nullable', Rule::unique('users', 'cpf')->ignore($this->userId),],
            'avatar' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048',],
            'password' => ['nullable', 'confirmed', Password::min(6),],
            'birthday' => ['nullable', 'date',],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Informe seu nome.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',

            'cpf.unique' => 'Este CPF já está cadastrado.',

            'avatar.image' => 'O arquivo deve ser uma imagem.',
            'avatar.max' => 'A imagem deve ter no máximo 2MB.',

            'password.confirmed' => 'As senhas não conferem.',
        ];
    }

    public function mount($userId = null)
    {
        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->authorize('update', $this->user);
        } else {
            $this->user = Auth::user();
        }

        $this->userId = $this->user->id;

        $this->fill(
            $this->user->only([
                'gender',
                'name',
                'cargo',
                'birthday',
                'naturalness',
                'civil_status',
                //'information',

                'cpf',
                'rg',
                'rg_expedition',

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

                'facebook',
                'instagram',
                'linkedin',
                'twitter',
            ])
        );

        $this->avatarPreview = $this->user->avatar
            ? Storage::url($this->user->avatar)
            : null;
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
        $this->avatarPreview = $this->avatar->temporaryUrl();
    }

    public function removeAvatar()
    {
        $this->avatar = null;
        $this->avatarPreview = $this->user?->avatar
            ? Storage::url($this->user->avatar)
            : null;
    }

    public function save()
    {
        try {

            $this->validate($this->rules(), $this->messages());

            $data = [

                'gender' => $this->gender,
                'name' => $this->name,
                'cargo' => $this->cargo,
                'birthday' => $this->birthday,
                'naturalness' => $this->naturalness,
                'civil_status' => $this->civil_status,
                //'information' => $this->information,

                'cpf' => $this->cpf,
                'rg' => $this->rg,
                'rg_expedition' => $this->rg_expedition,

                'phone' => $this->phone,
                'cell_phone' => $this->cell_phone,
                'whatsapp' => $this->whatsapp,
                'email' => $this->email,
                'additional_email' => $this->additional_email,
                'telegram' => $this->telegram,

                'zipcode' => $this->zipcode,
                'street' => $this->street,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'state' => $this->state,
                'complement' => $this->complement,
                'number' => $this->number,

                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
                'linkedin' => $this->linkedin,
                'twitter' => $this->twitter,

            ];

            // avatar
            if ($this->avatar) {

                // remove antiga
                if ($this->user?->avatar) {
                    Storage::disk('public')->delete($this->user->avatar);
                }

                $data['avatar'] = $this->avatar->store('company/'.$this->user->company->uuid.'/user','public');
            }

            // senha
            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            $this->user->update($data);

            $this->dispatch(
                'swal:success',
                [
                    'title' => 'Sucesso',
                    'text' => 'Conta atualizada com sucesso.',
                ]
            );
        } catch (ValidationException $e) {
            $this->dispatch('scroll-to-error');
            //dd($e);
            throw $e;
        }        
    }

    public function updatedZipcode(string $value)
    {        
        $this->zipcode = preg_replace('/[^0-9]/', '', $value);

        if(strlen($this->zipcode) === 8){
            $response = Http::get("https://viacep.com.br/ws/{$this->zipcode}/json/")->json();            
            if(!isset($response['erro'])){                
                $this->street = $response['logradouro'] ?? '';
                $this->neighborhood = $response['bairro'] ?? '';
                $this->state = $response['uf'] ?? '';
                $this->city = $response['localidade'] ?? '';
                $this->complement = $response['complemento'] ?? '';      
            }else{                
                $this->addError('zipcode', 'CEP não encontrado.'); 
            }
        }
    }

    #[Layout('components.layouts.company', ['title' => 'Minha Conta'])]
    public function render()
    {
        return view('livewire.company.user.user-form');
    }
}
