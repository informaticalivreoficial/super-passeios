<?php

namespace App\Livewire\Company\Finance;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;

class Statement extends Component
{
    use WithPagination;

    public string $status = '';

    public string $type = '';

    public function render()
    {
        $company = Auth::guard('customer')->user()->company;

        $transactions = WalletTransaction::query()
            ->whereCompanyId($company->id)

            ->when($this->status, fn($q) =>
                $q->where('status', $this->status))

            ->when($this->type, fn($q) =>
                $q->where('type', $this->type))

            ->latest()
            ->paginate(20);

        return view('livewire.company.finance.statement', [
            'transactions' => $transactions
        ]);
    }
}
