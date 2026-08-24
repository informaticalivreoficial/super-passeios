<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TourTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourDateResource;
use App\Http\Resources\TourResource;
use App\Models\Company;
use App\Models\Tour;
use App\Models\TourDate;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min((int) $request->per_page ?: 15, 50);

        $tours = Tour::query()
            ->where('active', true)
            ->with(['company', 'vessel', 'images'])
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->city, fn($q) => $q->whereHas('company', fn($cq) => $cq->where('city', $request->city)))
            ->when($request->type, fn($q) => $q->where('tour_type', $request->type))
            ->when($request->min_price, fn($q) => $q->where('price', '>=', $request->min_price))
            ->when($request->max_price, fn($q) => $q->where('price', '<=', $request->max_price))
            ->when($request->date, fn($q) => $q->whereHas('tourDates', fn($dq) => $dq->available()->where('date', '>=', $request->date)))
            ->when($request->order === 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
            ->when($request->order === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
            ->when($request->order === 'date_asc', fn($q) => $q->orderBy(
                TourDate::select('date')
                    ->whereColumn('tour_dates.tour_id', 'tours.id')
                    ->where('active', true)
                    ->where('date', '>=', now()->toDateString())
                    ->orderBy('date')
                    ->limit(1),
                'asc'
            ))
            ->when(!$request->order || $request->order === 'newest', fn($q) => $q->latest())
            ->paginate($perPage);

        return TourResource::collection($tours);
    }

    public function show(Tour $tour)
    {
        return new TourResource($tour->load(['company', 'vessel', 'images']));
    }

    public function dates(Tour $tour)
    {
        $dates = $tour->tourDates()
            ->available()
            ->orderBy('date')
            ->get();

        return TourDateResource::collection($dates);
    }

    public function cities()
    {
        $cities = Company::query()
            ->whereNotNull('city')
            ->whereHas('tours', fn($q) => $q->where('active', true)->whereHas('tourDates', fn($dq) => $dq->available()))
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return response()->json(['data' => $cities->values()]);
    }

    public function types()
    {
        $types = collect(TourTypeEnum::cases())
            ->map(fn(TourTypeEnum $type) => [
                'value' => $type->value,
                'label' => $type->label(),
            ])
            ->toArray();

        return response()->json(['data' => $types]);
    }
}
