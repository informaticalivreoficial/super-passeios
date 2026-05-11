<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyNotExists
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->company_id) {

            return redirect()->route(
                'company.company.edit', $user->company_id
            );
        }

        return $next($request);
    }
}