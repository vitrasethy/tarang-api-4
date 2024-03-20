<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['venue', 'user'])->get();

        return ReservationResource::collection($reservations);
    }

    public function store(ReservationRequest $request)
    {
        $validated = $request->validated();

        Reservation::create([
            ...$validated,
            'user_id' => 1,
        ]);

        return response()->noContent();
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['venue', 'user']);

        return new ReservationResource($reservation);
    }

    public function update(ReservationRequest $request, Reservation $reservation)
    {
        $validated = $request->validated();

        $reservation->update($validated);

        return response()->noContent();
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->noContent();
    }
}
