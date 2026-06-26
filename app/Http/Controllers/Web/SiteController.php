<?php

namespace App\Http\Controllers\Web;

use App\Enums\TourTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Config;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Support\Seo;
use Illuminate\Validation\Rule;

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
        $cities = Company::where('status', true)
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values();

        $tours = Tour::with(['company', 'images'])
            ->where('active', true)
            ->whereHas('company', fn($q) => $q->where('status', true))
            ->whereHas('dates', fn($q) => $q->where('active', true)->where('status', 'OPEN')->where('date', '>=', now()))
            ->orderByDesc('views')
            ->limit(12)
            ->get();

        $companies = Company::where('status', true)
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

    public function companies()
    {
        $companies = Company::where('status', true)
            ->with(['images', 'tours'])
            ->withCount([
                'tours as active_tours_count' => fn($q) => $q->where('active', true)
                    ->whereHas('dates', fn($q) => $q->where('active', true)
                        ->where('status', 'OPEN')
                        ->where('date', '>=', now())
                    ),
                'bookings as bookings_count',
            ])
            ->orderByDesc('views')
            ->orderByDesc('bookings_count')
            ->orderByDesc('active_tours_count')
            ->paginate(12);

        $head = $this->seo->render('Empresas que oferecem passeios para você' ?? config('app.name'),
            'Empresas que oferecem passeios para você' ?? config('app.name'),
            route('web.site.companies'),
            $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );

        return view('web.' . $this->config->template . '.companies.companies-list', [
            'companies' => $companies,
            'head' => $head
        ]);
    }

    public function loadMore(Request $request)
    {
        $companies = Company::where('status', true)
            ->with(['images'])
            ->withCount([
                'tours as active_tours_count' => fn($q) => $q->where('active', true)
                    ->whereHas('dates', fn($q) => $q
                        ->where('active', true)
                        ->where('status', 'OPEN')
                        ->where('date', '>=', now())
                    ),
                'bookings as bookings_count',
            ])
            ->orderByDesc('views')
            ->orderByDesc('bookings_count')
            ->orderByDesc('active_tours_count')
            ->paginate(12, ['*'], 'page', $request->page);

        $html = view('web.' . $this->config->template . '.companies.partials.company-card', [
            'companies' => $companies,
        ])->render();

        return response()->json([
            'companies' => $companies->items(),
            'html'      => $html,
            'has_more'  => $companies->hasMorePages(),
        ]);
    }

    public function company(string $slug)
    {
        $company = Company::where('status', true)
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

        return view('web.'.$this->config->template.'.companies.company', [
            'company' => $company,
            'tours' => $tours
        ]);
    }

    public function tour(string $slug, string $uuid)
    {
        $company = Company::where('status', true)
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

        $head = $this->seo->render($tour->title ?? config('app.name'),
            $tour->description ?? config('app.name'),
            route('web.home'),
            $tour->cover() ?? asset('theme/images/image.jpg')
        );

        return view('web.'.$this->config->template.'.tours.tour', [
            'head' => $head,
            'tour' => $tour,
            'dates' => $dates,
            'company' => $company
        ]);
    }

    public function tours(Request $request)
    {
        $request->validate([
            'cidade'    => ['nullable', 'string', 'max:100'],
            'tipo' => ['nullable', 'string', Rule::in(TourTypeEnum::values())],
            'preco_min' => ['nullable', 'numeric', 'min:0'],
            'preco_max' => ['nullable', 'numeric', 'min:0'],
        ]);

        $cities = Company::where('status', true)
            ->whereNotNull('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $tours = Tour::with([
                'company',
                'images' => fn($q) => $q->limit(1),
                'dates'  => fn($q) => $q->where('active', true)
                                        ->where('status', 'OPEN')
                                        ->where('date', '>=', now())
                                        ->orderBy('date')
                                        ->limit(1),
            ])
            ->where('active', true)
            ->whereHas('company', function ($q) use ($request) {
                $q->where('status', true);
                if ($request->cidade) {
                    $q->where('city', $request->cidade);
                }
            })
            ->whereHas('dates', fn($q) => $q->where('active', true)
                                            ->where('status', 'OPEN')
                                            ->where('date', '>=', now()))
            ->when($request->tipo,      fn($q) => $q->where('tour_type', $request->tipo))
            ->when($request->preco_max, fn($q) => $q->where('price', '<=', $request->preco_max))
            ->when($request->preco_min, fn($q) => $q->where('price', '>=', $request->preco_min))
            ->orderByDesc('views')
            ->paginate(12)
            ->withQueryString();

        $head = $this->seo->render('Passeios', 'Passeios', '', route('web.site.tours'));

        return view('web.'.$this->config->template.'.tours.index', [
            'head'   => $head,
            'tours'  => $tours,
            'cities' => $cities,
        ]);
    }

    public function contact()
    {
        return view('web.'.$this->config->template.'.contact',[
            'success' => false
        ]);
    }

    public function search()
    {
        return view('web.'.$this->config->template.'.search');
    }

    

}
