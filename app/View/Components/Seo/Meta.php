<?php

namespace App\View\Components\Seo;

use App\Support\Seo\SeoData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Meta extends Component
{
    public function __construct(
        public SeoData $seo
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.seo.meta');
    }
}