<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomerRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer || !$customer->hasRole($role)) {
            // Não expõe se a conta existe ou qual role tem — só nega.
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}