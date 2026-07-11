<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Support\Seo\Schema;
use App\Support\Seo\Seo;

class PartnerLandingController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = Config::first();
    }

    public function __invoke()
    {
        $seo = Seo::make()
            ->title('Para Empresas | ' . config('app.name'))
            ->description('Cadastre sua empresa e venda mais passeios náuticos.')
            ->image($this->config->getmetaimg() ?? asset('theme/images/image.jpg'))
            ->schema(Schema::organization())
            ->schema(Schema::website())
            ->build();

        return view('web.landing.partner', compact('seo'));
    }
}
