<?php

namespace App\Livewire\Company\Booking;

use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class BookingIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $paymentFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPaymentFilter(): void
    {
        $this->resetPage();
    }

    public function setDeleteId($id): void
    {
        $this->dispatch('swal:confirm', [
            'title'        => 'Cancelar Reserva?',
            'text'         => 'Essa ação não pode ser desfeita.',
            'icon'         => 'warning',
            'confirmEvent' => 'deleteBooking',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteBooking')]
    public function deleteBooking($id): void
    {
        $booking = Booking::findOrFail($id);
        $this->authorize('delete', $booking);
        $booking->delete();

        $this->dispatch('swal:success', [
            'title' => 'Cancelada!',
            'text'  => 'Reserva cancelada com sucesso.',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    #[Layout('components.layouts.company', ['title' => 'Gerenciar Reservas', 'bracrhumb' => 'Gerenciar Reservas'])]
    public function render()
    {
        $customer = Auth::guard('customer')->user();

        $bookings = Booking::query()
            ->where('company_id', $customer->company_id)
            ->with(['tour', 'tourDate', 'customer'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('customer_name', 'LIKE', "%{$this->search}%")
                          ->orWhere('customer_email', 'LIKE', "%{$this->search}%")
                          ->orWhere('uuid', 'LIKE', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->paymentFilter, fn($q) => $q->where('payment_status', $this->paymentFilter))
            ->latest()
            ->paginate(20);

        return view('livewire.company.booking.booking-index', compact('bookings'));
    }
}
