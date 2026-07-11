<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()
            ->bookings() // precisa existir essa relação no Customer, ver nota abaixo
            ->with(['tour', 'tourDate'])
            ->latest()
            ->paginate(10);

        return BookingResource::collection($bookings);
    }

    public function show(Request $request, $uuid)
    {
        $booking = $request->user()
            ->bookings()
            ->where('uuid', $uuid)
            ->with(['tour', 'tourDate'])
            ->firstOrFail();

        return new BookingResource($booking);
    }
}
