<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyNotExists
{
    public function handle(Request $request, Closure $next): Response
    {
        $customer = auth('customer')->user();

        if ($customer && $customer->company_id) {
            return redirect()->route('company.company.edit', $customer->company->uuid);
        }

        return $next($request);
    }
}