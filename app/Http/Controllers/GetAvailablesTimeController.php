<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAvailablesTimeRequest;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use function Pest\Laravel\json;

class GetAvailablesTimeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetAvailablesTimeRequest $request)
    {

        $validated = $request->validated();

        $busy_tarang = DB::table('reservations')->select('venue_id')
            ->where([
                ['date', '=', $validated["date"]],
            ])->whereTime('reservations.start_time', '>=', $validated["start_time"])
            ->whereTime('reservations.end_time', '<', $this->calculateEndTime($validated["start_time"], $validated["duration"]))
            ->get()->pluck('venue_id')->toArray();

        // $venues = DB::table('venues')->select('id', 'name')
        //     ->where([
        //         ['sport_type_id', '=', $validated["sport_type_id"]]
        //     ])
        //     ->whereNotIn('id', $busy_tarang)
        //     ->get()->toArray();

        // $venues = DB::table('venues')->select('venues.*')
        //     ->leftJoin('reservations', function ($join) use ($validated) {
        //         $join->on('venues.id', '=', 'reservations.venue_id')
        //             ->where('reservations.date', '=', $validated["date"])
        //             ->whereTime('reservations.start_time', '<=', $validated["start_time"])
        //             ->whereTime('reservations.end_time', '>=', $this->calculateEndTime($validated["start_time"], $validated['duration']));
        //     })
        //     ->whereNull('reservations.venue_id')
        //     ->where('venues.sport_type_id', '=', $validated["sport_type_id"])
        //     ->get();

        return response()->json(['venues' => $busy_tarang]);
    }

    private function convertTimeToDecimal($timeString)
    {
        $hours = date('G', strtotime($timeString));
        $minutes = date('i', strtotime($timeString));
        $decimalHours = $hours + ($minutes / 60);
        return $decimalHours;
    }

    private function convertDecimalToTime($decimalTime)
    {
        $hours = floor($decimalTime);
        $minutes = ($decimalTime - $hours) * 60;
        return sprintf('%02d:%02d:00', $hours, $minutes);
    }

    private function calculateEndTime($start_time, $duration)
    {
        // Parse start_time to Carbon instance
        $start_time = Carbon::createFromFormat('H:i', $start_time);

        // Calculate end time by adding duration to start time
        $end_time = $start_time->copy()->addMinutes($duration);

        // Format end time as "HH:MM" string
        return $end_time->format('H:i');
    }
}
