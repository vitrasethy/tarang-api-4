<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindReservationRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Notifications\SendReminderSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(["venue.sportType", "user", "matchGame.team1", "matchGame.team2"]);

        if ($request->has('all')) {
            return ReservationResource::collection($query->latest()->get());
        }

        return ReservationResource::collection($query->latest()->paginate(5));
    }

    public function store(ReservationRequest $request)
    {
        $reservation = Reservation::create([
            ...$request->validated(),
            "user_id" => auth()->id(),
        ]);

        $user = auth()->user();

//        $delay = Carbon::parse("$request->input('date') $request->input('start_time')")->subMinutes(2);
//        $user->notify(new SendReminderSMS($request->input('start_time')))->delay($delay);

        return new ReservationResource($reservation);
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(["venue", "user"]);

        return new ReservationResource($reservation);
    }

    public function update(
        ReservationRequest $request,
        Reservation $reservation
    ) {
        $validated = $request->validated();

        $reservation->update($validated);

        return response()->noContent();
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->noContent();
    }

    public function show_user(Request $request)
    {
        $query = Reservation::with(["venue.sportType", "user", "matchGame.team1", "matchGame.team2"])
            ->where("user_id", auth()->id())->latest();

        $reservations = $request->has('all')
            ? $query->get()
            : $query->paginate(5);

        return new ReservationCollection($reservations);
    }

    public function find_reservation(FindReservationRequest $request)
    {
        $validated = $request->validated();

        $date = Carbon::parse($validated['date'])->toDateString();
        $start_time = Carbon::parse($validated['start_time'])->toTimeString();
        $end_time = Carbon::parse($validated['end_time'])->toTimeString();

        $reservation = Reservation::where([
            ['date', '=', $date],
            ['venue_id', '=', $validated['venue_id']],
        ])->where(function ($query) use ($start_time, $end_time) {
            $query->where([
                ['start_time', '<=', $start_time],
                ['end_time', '>', $start_time],
            ])->orWhere([
                ['start_time', '<', $end_time],
                ['end_time', '>=', $end_time],
            ])->orWhere([
                ['start_time', '>=', $start_time],
                ['end_time', '<=', $end_time],
            ]);
        })->exists();

        return response()->json([
            'is_founded' => !$reservation,
        ]);
    }
}
