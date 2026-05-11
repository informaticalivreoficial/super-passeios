<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyCreated
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Super admin ignora
        |--------------------------------------------------------------------------
        */

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | Empresa ainda não cadastrada
        |--------------------------------------------------------------------------
        */

        if (
            $user->isCompany()
            && !$user->company_id
        ) {

            return redirect()
                ->route('company.company.create')

                ->with(
                    'warning',
                    'Cadastre sua empresa primeiro.'
                );
        }

        return $next($request);
    }
}
