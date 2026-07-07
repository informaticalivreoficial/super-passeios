<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerMagicAccessController extends Controller
{
    public function __invoke(string $token)
    {
        $customer = Customer::where('magic_token', $token)->first();

        if (!$customer) {
            // Token não existe: ou nunca existiu, ou já foi consumido antes
            abort(404, 'Este link já foi utilizado ou é inválido. Solicite um novo acesso em "Meus Pedidos".');
        }

        if ($customer->magic_token_expires_at < now()) {
            abort(404, 'Este link expirou. Solicite um novo acesso em "Meus Pedidos".');
        }

        $customer->forceFill([
            'magic_token' => null,
            'magic_token_expires_at' => null,
        ])->save();

        if (!$customer->hasRole('client')) {
            abort(403, 'Acesso não autorizado.');
        }

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.orders.index');
    }
}
