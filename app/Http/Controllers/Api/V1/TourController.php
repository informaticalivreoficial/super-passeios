<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourDateResource;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $tours = Tour::query()
            ->where('active', true)
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->city, fn($q) => $q->whereHas('company', fn($cq) => $cq->where('city', $request->city)))
            ->with(['company', 'vessel'])
            ->paginate(15);

        return TourResource::collection($tours);
    }

    public function show(Tour $tour)
    {
        return new TourResource($tour->load(['company', 'vessel']));
    }

    public function dates(Tour $tour)
    {
        $dates = $tour->tourDates()
            ->available() // reaproveitando o scope que já criamos!
            ->orderBy('date')
            ->get();

        return TourDateResource::collection($dates);
    }
}
