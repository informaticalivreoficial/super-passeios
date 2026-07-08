<?php

namespace App\Livewire\Dashboard\Finance;

use App\Enums\WithdrawalStatusEnum;
use App\Models\Withdrawal;
use App\Services\Wallet\WithdrawalService;
use App\Traits\WithToastr;
use Livewire\WithPagination;
use Livewire\Component;

class WithdrawalsIndex extends Component
{
    use WithPagination, WithToastr;

    public string $statusFilter = 'requested';
    public ?Withdrawal $selectedWithdrawal = null;

    public bool $showRejectModal = false;
    public string $rejectReason = '';

    public bool $showPayModal = false;
    public string $paymentReference = '';

    public bool $showApproveConfirmModal = false;

    public function setFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function openApprove(Withdrawal $withdrawal)
    {
        $withdrawal->load(['bankAccount', 'company']);

        $holderDocument = preg_replace('/\D/', '', $withdrawal->bankAccount?->holder_document ?? '');
        $companyDocument = preg_replace('/\D/', '', $withdrawal->company->document_company ?? '');
        $responsableCpf = preg_replace('/\D/', '', $withdrawal->company->responsable_cpf ?? '');

        $matches = $holderDocument && (
            $holderDocument === $companyDocument || $holderDocument === $responsableCpf
        );

        $this->selectedWithdrawal = $withdrawal;

        // Se o titular bate, aprova direto sem fricção extra.
        // Se diverge (ou não tem documento cadastrado), pede confirmação.
        if ($holderDocument && $matches) {
            $this->doApprove($withdrawal);
        } else {
            $this->showApproveConfirmModal = true;
        }
    }

    public function confirmApproveAnyway(WithdrawalService $service)
    {
        $this->doApprove($this->selectedWithdrawal);
        $this->showApproveConfirmModal = false;
    }

    protected function doApprove(Withdrawal $withdrawal)
    {
        try {
            app(WithdrawalService::class)->approve($withdrawal);
            $this->toastSuccess('Saque aprovado com sucesso.');
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function openReject(Withdrawal $withdrawal)
    {
        $this->selectedWithdrawal = $withdrawal;
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    public function openPay(Withdrawal $withdrawal)
    {
        $this->selectedWithdrawal = $withdrawal;
        $this->paymentReference = '';
        $this->showPayModal = true;
    }

    // public function approve(Withdrawal $withdrawal, WithdrawalService $service)
    // {
    //     try {
    //         $service->approve($withdrawal);
    //         $this->toastr('success', 'Saque aprovado com sucesso.');
    //     } catch (\Exception $e) {
    //         $this->toastr('error', $e->getMessage());
    //     }
    // }

    public function confirmReject(WithdrawalService $service)
    {
        try {
            $service->reject($this->selectedWithdrawal, $this->rejectReason ?: null);
            $this->showRejectModal = false;
            $this->toastSuccess('Saque recusado. Saldo devolvido à operadora.');
        } catch (\Exception $e) {
            $this->$this->toastError($e->getMessage());
        }
    }

    public function confirmPay(WithdrawalService $service)
    {
        $this->validate([
            'paymentReference' => 'required|string|min:3',
        ], [
            'paymentReference.required' => 'Informe o comprovante/código da transferência.',
        ]);

        try {
            $service->pay($this->selectedWithdrawal, $this->paymentReference);
            $this->showPayModal = false;
            $this->toastSuccess('Saque marcado como pago.');
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function render()
    {
        $withdrawals = Withdrawal::with(['company', 'bankAccount'])
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(15);

        $counts = [
            'requested' => Withdrawal::where('status', WithdrawalStatusEnum::REQUESTED)->count(),
            'approved'  => Withdrawal::where('status', WithdrawalStatusEnum::APPROVED)->count(),
            'paid'      => Withdrawal::where('status', WithdrawalStatusEnum::PAID)->count(),
            'rejected'  => Withdrawal::where('status', WithdrawalStatusEnum::REJECTED)->count(),
        ];

        return view('livewire.dashboard.finance.withdrawals-index', [
            'withdrawals' => $withdrawals,
            'counts' => $counts,
        ])->with('title', 'Gerenciador Financeiro - Saques');
    }
}
