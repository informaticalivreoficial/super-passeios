<?php

namespace App\Livewire\Dashboard\Customers;

use App\Models\Customer;
use Livewire\Component;

class CustomerShow extends Component
{
    public Customer $customer;

    public function mount(Customer $customer): void
    {
        $this->customer = $customer->load(['company', 'bookings.tour']);
    }

    public function render()
    {
        return view('livewire.dashboard.customers.customer-show')
            ->with('title', 'Perfil de ' . $this->customer->name);
    }
}