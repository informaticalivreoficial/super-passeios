<?php

namespace App\Livewire\Web\Customer;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class OrderShow extends Component
{
    public Booking $booking;

    public function mount(Booking $booking): void
    {
        // Garante que o customer só veja o próprio pedido
        abort_unless($booking->customer_id === Auth::guard('customer')->id(), 403);

        $this->booking = $booking->load('tourDate.tour', 'customer');
    }

    #[Layout('web.client.create', ['title' => 'Meu pedido'])]
    public function render()
    {
        return view('livewire.web.customer.order-show');
    }
}
