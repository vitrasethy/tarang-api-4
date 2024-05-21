<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Venue;

class MobileReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::latest()->get();
        $resource = [];
        foreach ($reservations as $reservation) {
            $venue = Venue::find($reservation->id);
            $resource = [
                ...$reservation,
                'venue_name' => $venue->name,
            ];
        }
        return response()->json($resource);
    }
}
