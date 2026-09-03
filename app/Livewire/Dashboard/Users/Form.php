<?php

namespace App\Livewire\Dashboard\Users;

use App\Models\User;
use App\Services\ViaCepService;
use App\Traits\WithToastr;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Form extends Component
{
    use WithFileUploads, WithToastr;

    public User $user;

    public $userId;  

    public $foto;
    public $fotoUrl;

    public $roles;
    public array $roleLabels = [
        'super-admin' => 'Super Administrador',
        'admin'       => 'Administrador',
        'manager'     => 'Gerente',
    ];
    public $roleSelected = '';

    // Personal
    public $name, $gender, $birthday, $naturalness, $civil_status, $avatar, $information;

    // Documents
    public $cpf, $rg, $rg_expedition;

    // Address
    public $zipcode = '', $street, $neighborhood, $city, $state, $complement, $number;

    // Contact
    public $phone, $cell_phone, $whatsapp, $email, $additional_email, $telegram;

    // Social
    public $facebook, $instagram, $linkedin, $twitter;

    // Password
    public $code;
    public $code_confirmation;
    
    protected function rulesCreate(): array
    {
        return [
            'name'         => 'required|min:3',
            'gender'       => 'required|in:masculino,feminino',
            'civil_status' => 'required|in:casado,separado,solteiro,divorciado,viuvo',
            'email'        => 'required|email|unique:users,email',
            'cpf'          => 'required|cpf|unique:users,cpf',
            'cell_phone'   => 'required',
            'birthday'     => 'required|date_format:d/m/Y|before:today',
            'information'  => 'nullable|string|max:2000',
            'roleSelected' => 'required|in:manager,admin,super-admin',
            'code'         => 'required|min:6|confirmed',
        ];
    }

    protected function rulesUpdate(): array
    {
        return [
            'name'         => 'required|min:3|max:191',
            'gender'       => 'required|in:masculino,feminino',
            'civil_status' => 'required|in:casado,separado,solteiro,divorciado,viuvo',
            'email'        => 'required|email|unique:users,email,' . $this->userId,
            'cpf'          => 'required|cpf|unique:users,cpf,' . $this->userId,
            'cell_phone'   => 'required',
            'birthday'     => 'required|date_format:d/m/Y',
            'information'  => 'nullable|string|max:2000',
            'roleSelected' => 'required|in:manager,admin,super-admin',
        ];
    }     

    public function mount($userId = null): void
    {
        if ($userId) {
            $user = User::findOrFail($userId);
            $this->authorize('update', $user);
            $this->userId = $user->id;
            $this->fill($user->toArray());
            $this->roleSelected = $user->roles->pluck('name')->first() ?? '';
        }
    }    

    public function save(): void
    {
        $this->userId ? $this->update() : $this->create();
    }

    public function create(): void
    {
        try {
            $this->authorize('create', User::class);

            $fotoFile = $this->foto;

            $validated = $this->validate($this->rulesCreate());

            if ($fotoFile) {
                $validated['avatar'] = $this->convertAndStore($fotoFile);
            }

            $validated['password'] = Hash::make($this->code);

            $extras = [
                'naturalness', 'rg', 'rg_expedition',
                'phone', 'whatsapp', 'additional_email', 'telegram',
                'number', 'zipcode', 'street', 'neighborhood',
                'city', 'state', 'complement',
                'facebook', 'instagram', 'linkedin', 'twitter', 'information',
            ];

            foreach ($extras as $field) {
                $validated[$field] = $this->$field;
            }

            $user = User::create($validated);
            $user->syncRoles([$this->roleSelected]);

            $this->reset(['code', 'code_confirmation', 'foto', 'fotoUrl']);

            $this->dispatch('swal', [
                'title'             => 'Sucesso!',
                'text'              => 'Usuário cadastrado com sucesso!',
                'icon'              => 'success',
                'timer'             => 2000,
                'showConfirmButton' => false,
            ]);

            redirect()->route('admin.users.edit', $user->id);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('scroll-to-first-error');
            $this->toastError($e->validator->errors()->first());
            throw $e;
        }
    }

    public function update(): void
    {
        try {
            $fotoFile = $this->foto;

            $validated = $this->validate($this->rulesUpdate());

            $user = User::findOrFail($this->userId);

            $this->authorize('update', $user);

            if ($fotoFile) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $validated['avatar'] = $this->convertAndStore($fotoFile);
            }

            $user->update(array_merge($validated, [
                'naturalness'      => $this->naturalness,
                'rg'               => $this->rg,
                'rg_expedition'    => $this->rg_expedition,
                'phone'            => $this->phone,
                'whatsapp'         => $this->whatsapp,
                'additional_email' => $this->additional_email,
                'telegram'         => $this->telegram,
                'number'           => $this->number,
                'zipcode'          => $this->zipcode,
                'street'           => $this->street,
                'neighborhood'     => $this->neighborhood,
                'city'             => $this->city,
                'state'            => $this->state,
                'complement'       => $this->complement,
                'facebook'         => $this->facebook,
                'instagram'        => $this->instagram,
                'linkedin'         => $this->linkedin,
                'twitter'          => $this->twitter,
                'information'      => $this->information,
            ]));

            $user->syncRoles([$this->roleSelected]);

            $this->reset(['code', 'code_confirmation', 'foto', 'fotoUrl']);

            $this->dispatch('swal', [
                'title'             => 'Sucesso!',
                'text'              => 'Usuário atualizado com sucesso!',
                'icon'              => 'success',
                'timer'             => 2000,
                'showConfirmButton' => false,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('scroll-to-first-error');
            $this->toastError($e->validator->errors()->first());
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

    public function updatedFoto(): void
    {
        $this->validateOnly('foto', [
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        if ($this->foto) {
            $this->fotoUrl = $this->foto->temporaryUrl();
        } else {
            $this->fotoUrl = null;
        }
    }

    protected function convertAndStore($file): string
    {
        $manager = new ImageManager(new Driver());

        $image = $manager->read($file->getRealPath());

        $filename = uniqid('user_', true) . '.webp';
        $directory = 'user';
        $path = $directory . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        $image->resizeDown(800, 800, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->toWebp(85)->save($fullPath);

        return $path;
    }

    public function render()
    {
        return view('livewire.dashboard.users.form')->with('title', $this->userId ? 'Editar Usuário' : 'Cadastrar Usuário');
    }
}
