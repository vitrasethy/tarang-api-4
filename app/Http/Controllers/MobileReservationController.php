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
            $venue = Venue::find($reservation->venue_id); // Corrected to use $reservation->venue_id instead of $reservation->id

            $resource[] = [
                'id' => $reservation->id,
                'phone' => $reservation->phone,
                'user_id' => $reservation->user_id,
                'venue_id' => $reservation->venue_id,
                'team_id' => $reservation->team_id,
                'attendee' => $reservation->attendee,
                'date' => $reservation->date,
                'start_time' => $reservation->start_time,
                'end_time' => $reservation->end_time,
                'find_team' => $reservation->find_team,
                'find_member' => $reservation->find_member,
                'deleted_at' => $reservation->deleted_at,
                'created_at' => $reservation->created_at,
                'updated_at' => $reservation->updated_at,
                'venue_name' => $venue->name,
            ];
        }
        return response()->json($resource);
    }
}
