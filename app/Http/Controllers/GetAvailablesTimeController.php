<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class GetAvailablesTimeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $existing_bookings = DB::table('reservations')->select('id', 'start_time', 'end_time')->where('date', '=', $request->date)->get()->toArray();
        $new_available_time_slots = [];

        if ($existing_bookings) {
            foreach ($existing_bookings as $booking) {
                $booking->start_time = $this->convertTimeToDecimal($booking->start_time);
                $booking->end_time = $this->convertTimeToDecimal($booking->end_time);
            }

            $times = array_merge(range(6, 22), array_map(function ($x) {
                return $x + 0.5;
            }, range(6, 21)));

            $duration = 0.5;  // Each time slot represents half an hour

            $available_time_slots = $this->find_available_time($existing_bookings, $times, $duration);

            // Sort available time slots in ascending order
            sort($available_time_slots);

            $new_available_time_slots = array_map([$this, 'convertDecimalToTime'], $available_time_slots);
        }

        return response()->json(['available_times' => $new_available_time_slots]);
    }

    function convertTimeToDecimal($timeString)
    {
        $hours = date('G', strtotime($timeString));
        $minutes = date('i', strtotime($timeString));
        $decimalHours = $hours + ($minutes / 60);
        return $decimalHours;
    }

    function convertDecimalToTime($decimalTime)
    {
        $hours = floor($decimalTime);
        $minutes = ($decimalTime - $hours) * 60;
        return sprintf('%02d:%02d:00', $hours, $minutes);
    }

    // find available time function
    function find_available_time($existing_bookings, $times, $duration)
    {
        $available_slots = [];
        $booked_slots = [];

        // Store existing bookings in a set for efficient lookup
        foreach ($existing_bookings as $booking) {
            $start_time = $booking->start_time;
            $end_time = $booking->end_time;

            $current_time = $start_time;
            while ($current_time < $end_time) {
                if ($current_time == 6.0) {
                    $booked_slots[] = $current_time;
                }

                $current_time += $duration;
                if ($current_time != $start_time) {
                    $booked_slots[] = $current_time;
                }
            }
        }

        // Check each time slot in the times array
        foreach ($times as $time_slot) {
            if (!in_array($time_slot, $booked_slots)) {
                $available_slots[] = $time_slot;
            } elseif (!in_array($time_slot + $duration, $booked_slots)) {
                $available_slots[] = $time_slot;
            }
        }

        return $available_slots;
    }
}
