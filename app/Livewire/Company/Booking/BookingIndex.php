<?php

namespace App\Livewire\Company\Booking;

use Livewire\Component;
use Livewire\Attributes\Layout;

class BookingIndex extends Component
{
    #[Layout('components.layouts.company', ['title' => 'Gerenciar Reservas'])]
    public function render()
    {
        return view('livewire.company.booking.booking-index');
    }
}
