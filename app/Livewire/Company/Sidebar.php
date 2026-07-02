<?php

namespace App\Livewire\Company;

use App\Models\Company;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect('/painel/login', navigate: true);
    }

    private function getCompany(): ?Company
    {
        return Auth::guard('customer')->user()->company;
    }

    public function render()
    {
        $company = $this->getCompany();

        if (!$company) {
            return view('livewire.company.sidebar', [
                'hasCompany' => false,
                'data'       => null,
                'company'    => null,
            ]);
        }

        return view('livewire.company.sidebar');
    }
}
