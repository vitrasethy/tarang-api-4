<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['venue', 'user'])->get();

        return ReservationResource::collection($reservations);
    }

    public function store(ReservationRequest $request)
    {
        Reservation::create([
            ...$request->validated(),
            'user_id' => 1,
        ]);

        return response()->noContent();
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['venue', 'user']);

        return new ReservationResource($reservation);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'phone' => ['sometimes', 'required', 'string'],
            'attendee' => ['sometimes', 'required', 'integer'],
            'date' => ['sometimes', 'required', 'date'],
            'start_time' => ['sometimes', 'required', 'date_format:H:i'],
            'end_time' => ['sometimes', 'required', 'date_format:H:i'],
            'venue_id' => ['sometimes', 'required', 'exists:venues,id'],
            'find_team' => ['sometimes', 'required', 'boolean'],
            'find_member' => ['sometimes', 'required', 'boolean'],
            'team_id' => ['sometimes', 'nullable', 'exists:teams,id'],
        ]);

        $reservation->update($validated);

        return response()->noContent();
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->noContent();
    }
}
