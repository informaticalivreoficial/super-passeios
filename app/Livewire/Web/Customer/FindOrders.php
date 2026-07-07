<?php

namespace App\Livewire\Web\Customer;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use App\Mail\Customer\CustomerOrderAccessMail;
use App\Models\Customer;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class FindOrders extends Component
{
    public string $cpf = '';
    public bool $sent = false;

    public function send(): void
    {
        $this->validate(['cpf' => ['required', 'string', 'min:11']]);

        $cleanCpf = preg_replace('/\D/', '', $this->cpf);
        $key = 'order-access:'.$cleanCpf;

        // Throttle: 3 tentativas a cada 5 minutos por CPF, evita spam de e-mail
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->sent = true; // mensagem genérica igual ao caminho normal
            return;
        }
        RateLimiter::hit($key, 300);

        $customer = Customer::where('cpf', $cleanCpf)->first();

        if ($customer && $customer->hasRole('client')) {
            $customer->update([
                'magic_token'            => Str::random(64),
                'magic_token_expires_at' => now()->addMinutes(30),
            ]);

            $link = route('customer.orders.access', ['token' => $customer->magic_token]);
            Mail::to($customer->email)->queue(new CustomerOrderAccessMail($customer, $link));
        }

        // ⚠️ Sempre mostra a mesma mensagem, exista ou não o CPF —
        // evita que alguém use esse form pra descobrir quais CPFs estão cadastrados.
        $this->sent = true;
    }

    #[Layout('web.client.create', ['title' => 'Meus Pedidos'])]
    public function render()
    {
        return view('livewire.web.customer.find-orders');
    }
}
