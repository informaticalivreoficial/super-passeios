<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyCreated
{
    public function handle(Request $request, Closure $next): Response
    {
        $customer = auth('customer')->user();

        if ($customer->isProprietary() && !$customer->company_id) {
            return redirect()
                ->route('company.company.create')
                ->with('warning', 'Cadastre sua empresa primeiro.');
        }

        return $next($request);
    }
}