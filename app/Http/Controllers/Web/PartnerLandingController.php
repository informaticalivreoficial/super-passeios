<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnerLandingController extends Controller
{
    public function __invoke()
    {
        return view('web.landing.partner', [
            'title' => 'Cadastre sua empresa e venda mais passeios náuticos',
        ]);
    }
}
