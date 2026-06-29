<?php

namespace App\Livewire\Company\Finance;

use Livewire\Component;
use App\Models\BankAccount;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class BankAccounts extends Component
{
    public bool $showModal = false;
    public ?int $editingId = null;

    // campos
    public string $type          = 'pix';
    public string $holder_name   = '';
    public string $holder_document = '';

    // PIX
    public string $pix_type = 'cpf';
    public string $pix_key  = '';

    // TED
    public string $bank_code     = '';
    public string $bank_name     = '';
    public string $agency        = '';
    public string $agency_digit  = '';
    public string $account       = '';
    public string $account_digit = '';
    public string $account_type  = 'checking';

    public bool $is_default = false;

    protected function rules(): array
    {
        $rules = [
            'type'              => 'required|in:pix,ted',
            'holder_name'       => 'required|string|max:255',
            'holder_document'   => 'required|string|max:18',
            'is_default'        => 'boolean',
        ];

        if ($this->type === 'pix') {
            $rules['pix_type'] = 'required|in:cpf,cnpj,email,phone,random';
            $rules['pix_key']  = 'required|string|max:255';
        } else {
            $rules['bank_code']     = 'required|string|max:10';
            $rules['bank_name']     = 'required|string|max:100';
            $rules['agency']        = 'required|string|max:10';
            $rules['account']       = 'required|string|max:20';
            $rules['account_digit'] = 'required|string|max:2';
            $rules['account_type']  = 'required|in:checking,savings';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'holder_name.required'     => 'Informe o nome do titular.',
            'holder_document.required' => 'Informe o CPF ou CNPJ.',
            'pix_key.required'         => 'Informe a chave PIX.',
            'bank_code.required'       => 'Informe o código do banco.',
            'bank_name.required'       => 'Informe o nome do banco.',
            'agency.required'          => 'Informe a agência.',
            'account.required'         => 'Informe o número da conta.',
            'account_digit.required'   => 'Informe o dígito da conta.',
        ];
    }

    private function getCompany(): Company
    {
        return Auth::guard('customer')->user()->company;
    }

    public function openModal(?int $id = null): void
    {
        $this->resetForm();

        if ($id) {
            $account = BankAccount::findOrFail($id);
            $this->editingId      = $account->id;
            $this->type           = $account->type;
            $this->holder_name    = $account->holder_name;
            $this->holder_document = $account->holder_document;
            $this->pix_type       = $account->pix_type ?? 'cpf';
            $this->pix_key        = $account->pix_key ?? '';
            $this->bank_code      = $account->bank_code ?? '';
            $this->bank_name      = $account->bank_name ?? '';
            $this->agency         = $account->agency ?? '';
            $this->agency_digit   = $account->agency_digit ?? '';
            $this->account        = $account->account ?? '';
            $this->account_digit  = $account->account_digit ?? '';
            $this->account_type   = $account->account_type ?? 'checking';
            $this->is_default     = $account->is_default;
        }

        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $company = $this->getCompany();

        $data = [
            'company_id'      => $company->id,
            'type'            => $this->type,
            'holder_name'     => $this->holder_name,
            'holder_document' => $this->holder_document,
            'is_default'      => $this->is_default,
            'pix_type'        => $this->type === 'pix' ? $this->pix_type : null,
            'pix_key'         => $this->type === 'pix' ? $this->pix_key : null,
            'bank_code'       => $this->type === 'ted' ? $this->bank_code : null,
            'bank_name'       => $this->type === 'ted' ? $this->bank_name : null,
            'agency'          => $this->type === 'ted' ? $this->agency : null,
            'agency_digit'    => $this->type === 'ted' ? $this->agency_digit : null,
            'account'         => $this->type === 'ted' ? $this->account : null,
            'account_digit'   => $this->type === 'ted' ? $this->account_digit : null,
            'account_type'    => $this->type === 'ted' ? $this->account_type : null,
        ];

        if ($this->editingId) {
            BankAccount::findOrFail($this->editingId)->update($data);
        } else {
            BankAccount::create($data);
        }

        $this->resetForm();

        $this->dispatch('swal:success', [
            'title' => 'Sucesso!',
            'text'  => $this->editingId ? 'Conta atualizada.' : 'Conta cadastrada.',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function setDefault(int $id): void
    {
        $company = $this->getCompany();

        BankAccount::where('company_id', $company->id)
            ->update(['is_default' => false]);

        BankAccount::findOrFail($id)
            ->update(['is_default' => true]);
    }

    public function setDeleteId(int $id): void
    {
        $this->dispatch('swal:confirm', [
            'title'         => 'Excluir conta?',
            'text'          => 'Essa ação não pode ser desfeita.',
            'icon'          => 'warning',
            'confirmEvent'  => 'deleteBank',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteBank')]
    public function deleteBank(int $id): void
    {
        BankAccount::findOrFail($id)->delete();

        $this->dispatch('swal:success', [
            'title' => 'Excluída!',
            'text'  => 'Conta bancária removida.',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function resetForm(): void
    {
        $this->reset([
            'editingId', 'type', 'holder_name', 'holder_document',
            'pix_type', 'pix_key', 'bank_code', 'bank_name',
            'agency', 'agency_digit', 'account', 'account_digit',
            'account_type', 'is_default', 'showModal',
        ]);

        $this->type        = 'pix';
        $this->pix_type    = 'cpf';
        $this->account_type = 'checking';
    }

    #[Layout('components.layouts.company', ['title' => 'Meus Bancos', 'bracrhumb' => 'Gerencie suas contas para recebimento de saques.'])]
    public function render()
    {
        $accounts = BankAccount::where('company_id', $this->getCompany()->id)
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return view('livewire.company.finance.bank-accounts', compact('accounts'));
    }
}
