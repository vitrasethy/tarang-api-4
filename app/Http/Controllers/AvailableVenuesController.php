<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailableVenuesController extends Controller
{
    public function filter(string $sport_type_id, string $option)
    {
        if ($option === 'today') {
            $reservations = Reservation::where('date', date("Y-m-d"))->orderBy('start_time')->get()->toArray();
            $venues = Venue::where('sport_type_id', $sport_type_id)->get();
            $available = [];

            foreach ($venues as $venue) {
                $each_venue_available = [];
                $current_time = date('H:i');
                $start_time = $current_time;
                if (Carbon::parse($current_time)->lessThan('07:00')){
                    $start_time = '07:00';
                }

                $filtered_reserves = array_filter($reservations, function ($item) use ($venue) {
                    return $item['venue_id'] === $venue->id;
                });

                foreach ($filtered_reserves as $key => $filtered_reserve) {
                    if ($key === array_key_last($filtered_reserves)
                        && Carbon::create($filtered_reserve['end_time'])->lessThan('21:00')) {
                        $each_venue_available[] = [
                            'start_time' => $filtered_reserve['end_time'],
                            'end_time' => '22:00',
                        ];
                    } elseif ($start_time !== $filtered_reserve['start_time']) {
                        $each_venue_available[] = [
                            'start_time' => $start_time,
                            'end_time' => $filtered_reserve['start_time'],
                        ];
                    }

                    $start_time = $filtered_reserve['start_time'];
                }

                $available[] = [
                    'id' => $venue->id,
                    'name' => $venue->name,
                    'available' => $each_venue_available,
                ];
            }

            return response()->json($available);
        }

        return response()->json([
            'error' => 'outside if statement',
            'data' => $sport_type_id,
        ]);
    }
}
