<?php

namespace App\Livewire\Dashboard\Users;

use App\Livewire\Concerns\WithSafeSorting;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
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

    public bool $updateMode = false;

        
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

    public function toggleStatus($id)
    {              
        $user = User::findOrFail($id);
        $user->status = !$user->status;        
        $user->save();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->dispatch('userId');
        $this->updateMode = true;
    }

    public function render()
    {
        $title = 'Gerentes';
        $users = User::query()
            ->role('manager')
            ->when($this->search, function($query){
                $query->orWhere('name', 'LIKE', "%{$this->search}%");
                $query->orWhere('email', "%{$this->search}%");
            })
            ->orderBy($this->safeSortField(), $this->safeSortDirection())
            ->paginate(35);
        return view('livewire.dashboard.users.users',[
            'users' => $users
        ])->with('title', $title);
    }
}
