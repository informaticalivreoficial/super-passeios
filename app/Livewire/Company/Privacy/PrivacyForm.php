<?php

namespace App\Livewire\Company\Privacy;

use App\Models\Company;
use App\Models\User;
use App\Notifications\CompanyDeletionCancelled;
use App\Notifications\CompanyDeletionRequested;
use App\Notifications\CompanyDeletionScheduled;
use Livewire\Component;
use Livewire\Attributes\Layout;

class PrivacyForm extends Component
{
    public ?Company $company = null;

    public function mount(): void
    {
        $this->company = auth('customer')->user()->company;

        if (!$this->company) {
            return;
        }

        $this->authorize('update', $this->company);
    }

    public function requestDeletion(): void
    {
        if (!$this->company?->exists) {
            return;
        }

        if ($this->company->available_balance > 0) {
            $this->dispatch('swal:warning', [
                'title'             => 'Saldo pendente!',
                'text'              => 'Saque seu saldo disponível antes de solicitar a exclusão da conta.',
                'icon'              => 'warning',
                'showConfirmButton' => false,
            ]);
            return;
        }

        $this->company->update([
            'deletion_requested_at'  => now(),
            'deletion_scheduled_for' => now()->addDays(7),
            'deletion_cancelled_at'  => null,
        ]);

        $this->company->refresh();

        $admins = User::role(['super-admin', 'admin'])->get();
        foreach ($admins as $admin) {
            $admin->notify(new CompanyDeletionRequested($this->company));
        }

        auth('customer')->user()->notify(new CompanyDeletionScheduled($this->company));

        $this->dispatch('swal:success', [
            'title'             => 'Exclusão agendada!',
            'text'              => 'Sua conta será excluída em ' . $this->company->deletion_scheduled_for->format('d/m/Y') . '. Você pode cancelar dentro desse período.',
            'timer'             => 4000,
            'showConfirmButton' => false,
        ]);
    }

    public function cancelDeletion(): void
    {
        if (!$this->company?->exists || !$this->company->isDeletionPending()) {
            return;
        }

        $this->company->update([
            'deletion_cancelled_at' => now(),
        ]);

        $this->company->refresh();

        auth('customer')->user()->notify(new CompanyDeletionCancelled($this->company));

        $this->dispatch('swal:success', [
            'title'             => 'Exclusão cancelada!',
            'text'              => 'Sua conta continua ativa normalmente.',
            'timer'             => 3000,
            'showConfirmButton' => false,
        ]);
    }

    #[Layout('components.layouts.company', ['title' => 'Privacidade', 'bracrhumb' => 'Gerencie a privacidade e exclusão da sua conta.'])]
    public function render()
    {
        return view('livewire.company.privacy.privacy-form');
    }
}
