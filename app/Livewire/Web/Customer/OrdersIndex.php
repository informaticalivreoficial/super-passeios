<?php

namespace App\Livewire\Web\Customer;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class OrdersIndex extends Component
{
    #[Layout('web.client.create', ['title' => 'Meus Pedidos'])]
    public function render()
    {
        $bookings = Auth::guard('customer')->user()
            ->bookings() // ajuste o nome do relationship se for diferente
            ->with('tourDate.tour')
            ->latest()
            ->get();

        return view('livewire.web.customer.orders-index', compact('bookings'));
    }
}
