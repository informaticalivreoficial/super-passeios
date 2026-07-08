<?php

namespace App\Livewire\Company\Booking;

use App\Models\Booking;
use App\Services\Booking\BookingCancellationService;
use Livewire\Attributes\Layout;
use App\Traits\WithToastr;
use Livewire\Component;

class BookingShow extends Component
{
    use WithToastr;

    public Booking $booking;
    public bool $confirmingCancel = false;
    public string $cancellationReason = '';

    public function mount(Booking $booking)
    {
        $this->authorize('view', $booking);
        $this->booking = $booking->load(['tour', 'tourDate', 'walletTransaction']);
    }

    public function confirmCancel()
    {
        $this->confirmingCancel = true;
    }

    public function cancelBooking(BookingCancellationService $service)
    {
        $service->handle($this->booking, $this->cancellationReason ?: null);

        $this->booking->refresh();
        $this->confirmingCancel = false;
        $this->cancellationReason = '';

        $this->toastr('success', 'Reserva cancelada com sucesso.');
    }

    public function render()
    {
        return view('livewire.company.booking.booking-show')
        ->layout('components.layouts.company', [
            'title' => 'Reserva #' . strtoupper(substr($this->booking->uuid, 0, 8)),
            'bracrhumb' => 'Detalhes da Reserva',
        ]);
    }
}
