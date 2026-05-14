<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Config;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Support\Seo;

class SiteController extends Controller
{
    protected $seo, $config;

    public function __construct()
    {
        $this->seo = new Seo();
        $this->config = Config::where('id', 1)->firstOrFail();
    }

    public function home()
    {
        $cities = Company::available()
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values();

        $tours = Tour::with(['company', 'images'])
            ->where('active', true)
            ->whereHas('company', fn($q) => $q->available())
            ->whereHas('dates', fn($q) => $q->where('active', true)->where('status', 'OPEN')->where('date', '>=', now()))
            ->orderByDesc('views')
            ->limit(12)
            ->get();

        $companies = Company::available()
            ->with('images')
            ->where('highlight', true)
            ->orderByDesc('views')
            ->limit(6)
            ->get();

        $head = $this->seo->render($this->config->app_name ?? config('app.name'),
            $this->config->information ?? config('app.name'),
            route('web.home'),
            $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );
        
        return view('web.'.$this->config->template.'.home', [
            'head' => $head,
            'tours' => $tours,
            'companies' => $companies,
            'cities' => $cities
        ]);
    }

    public function company(string $slug)
    {
        $config = $this->config();

        $company = Company::available()
            ->where('slug', $slug)
            ->with(['images'])
            ->firstOrFail();

        // incrementa views
        $company->increment('views');

        $tours = $company->tours()
            ->where('active', true)
            ->with('images')
            ->whereHas('dates', fn($q) => $q->where('active', true)->where('status', 'OPEN')->where('date', '>=', now()))
            ->orderByDesc('views')
            ->get();

        return view('web.'.$this->config->template.'.site.company', compact('config', 'company', 'tours'));
    }

    public function tour(string $slug, string $uuid)
    {
        $config = $this->config();

        $company = Company::available()
            ->where('slug', $slug)
            ->firstOrFail();

        $tour = Tour::where('uuid', $uuid)
            ->where('company_id', $company->id)
            ->where('active', true)
            ->with(['images', 'vessel', 'company'])
            ->firstOrFail();

        // incrementa views
        $tour->increment('views');

        $dates = $tour->dates()
            ->where('active', true)
            ->where('status', 'OPEN')
            ->where('date', '>=', now())
            ->orderBy('date')
            ->get();

        return view('web.'.$this->config->template.'.site.tour', compact('config', 'company', 'tour', 'dates'));
    }
}
