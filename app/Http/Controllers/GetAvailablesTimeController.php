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
     * Get all available Tarang and unavailable Tarang
     */
    public function __invoke(GetAvailablesTimeRequest $request)
    {

        $validated = $request->validated();

        $start_time = Carbon::parse($validated['start_time'])->format('H:i:s');
        $end_time = Carbon::parse($this->calculateEndTime($validated['start_time'], $validated['duration']))->format('H:i:s');

        $busy_tarang = Reservation::with('venue')
            ->whereDate('date', $validated['date'])
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

        $busy_venues = $busy_tarang->pluck('venue_id')->unique();

        $available_tarang = DB::table('venues')->where('sport_type_id', '=', $validated['sport_type_id'])
            ->whereNotIn('id', $busy_venues)
            ->get();


        return response()->json(
            [
                'sport_type_id' => $validated['sport_type_id'],
                'date' => $validated['date'],
                'start_time' => $start_time,
                'end_time' => $end_time,
                'duration' => $validated['duration'],
                'Unavailable_Tarang' => $busy_tarang,
                'Available_Tarang' => $available_tarang,
            ]
        );
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
