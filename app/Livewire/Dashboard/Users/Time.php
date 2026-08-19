<?php

namespace App\Livewire\Dashboard\Users;

use App\Livewire\Concerns\WithSafeSorting;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Time extends Component
{
    use WithPagination, WithSafeSorting;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    #[Locked]
    public string $sortField = 'name';

    public $delete_id;

    #[Locked]
    public string $sortDirection = 'asc';

    public bool $active;    

    #{Url}
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    protected function sortableFields(): array
    {
        return ['name', 'email', 'created_at', 'status'];
    }

    protected function defaultSortField(): string
    {
        return 'name';
    }

    public function toggleStatus($id)
    {              
        $user = User::findOrFail($id);
        $user->status = !$user->status;        
        $user->save();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Usuário?',
            'text' => 'Essa ação não pode ser desfeita.!',
            'showConfirmButton' => false,
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteUser',
            'confirmParams' => [$id],
        ]);        
    }
    #[On('deleteUser')]
    public function deleteUser($id): void
    {
        $user = User::where('id', $id)->first();
        if(!empty($user)){
            $this->authorize('delete', $user);
            $user->delete();

            $this->dispatch('swal:success', [
                'title' => 'Excluído!',
                'text' => 'Usuário removido com sucesso!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
        }
    }

    public function render()
    {
        $title = 'Time de Usuários';

        $users = User::role(['admin', 'super-admin'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'LIKE', "%{$this->search}%")
                    ->orWhere('email', 'LIKE', "%{$this->search}%");
                });
            })
            ->orderBy($this->safeSortField(), $this->safeSortDirection())
            ->paginate(15);

        return view('livewire.dashboard.users.time', [
            'users'      => $users,
            'roleLabels' => [
                'super-admin' => 'Super Administrador',
                'admin'       => 'Administrador',
            ],
        ])->with('title', $title);
    }
}
