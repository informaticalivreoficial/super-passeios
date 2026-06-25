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

        $user = auth('customer')->user();

        /*
        |--------------------------------------------------------------------------
        | Admin ignora
        |--------------------------------------------------------------------------
        */

        // if ($user->isProprietary()) {
        //     return $next($request);
        // }

        /*
        |--------------------------------------------------------------------------
        | Empresa ainda não cadastrada
        |--------------------------------------------------------------------------
        */

        if (
            $user->isProprietary()
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
