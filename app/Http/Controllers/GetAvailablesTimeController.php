<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAvailablesTimeRequest;
use App\Models\Reservation;
use App\Models\SportType;
use App\Models\Venue;
use Carbon\Carbon;

class GetAvailablesTimeController extends Controller
{
    /**
     * Get all available Tarang and unavailable Tarang
     */
    public function __invoke(GetAvailablesTimeRequest $request)
    {
        $validated = $request->validated();

        // initialize variable parse time using carbon
        $start_time = Carbon::parse($validated['start_time'])->format('H:i:s');
        $end_time = Carbon::parse($validated['end_time'])->format('H:i:s');
        $sport_type_id = $validated['sport_type_id'];
        $date = Carbon::parse($validated['date'])->toDateString();

        // find the unavailable tarang by reservations
        $busy_tarang = Reservation::with('venue')
            ->whereDate('date', $date)
            ->whereHas('venue', function ($query) use ($sport_type_id) {
                $query->where('sport_type_id', $sport_type_id);
            })
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where(function ($subQuery) use ($start_time, $end_time) {
                    $subQuery->where('start_time', '>=', $start_time)
                        ->whereTime('start_time', '<', $end_time);
                })
                    ->orWhere(function ($subQuery) use ($start_time, $end_time) {
                        $subQuery->whereTime('end_time', '<=', $end_time)
                            ->whereTime('end_time', '>', $start_time);
                    });
            })->get();

        // find unavailable tarang by get all venue id eg. [1,2,3,4]
        $busy_venues = $busy_tarang->pluck('venue_id')->unique();

        // get available tarang from unavailable venue id
        $available_tarang = Venue::with('sportType')->where('sport_type_id', '=', $validated['sport_type_id'])
            ->whereNotIn('id', $busy_venues)
            ->get();

        return response()->json(
            [
                'sport_type_id' => SportType::find($validated['sport_type_id']),
                'date' => $date,
                'start_time' => Carbon::parse($start_time)->format('H:i'),
                'end_time' => Carbon::parse($end_time)->format('H:i'),
                'unavailable_tarang' => $busy_tarang,
                'available_tarang' => $available_tarang,
            ]
        );
    }

    //    // calculate end time function
    //    private function calculateEndTime($start_time, $duration)
    //    {
    //        $start_time = Carbon::createFromFormat('H:i', $start_time);
    //        $end_time = $start_time->copy()->addMinutes($duration);
    //
    //        return $end_time->format('H:i');
    //    }
}
