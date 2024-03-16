<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Http\Resources\VenueResource;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::with('sportType')->get();

        return VenueResource::collection($venues);
    }

    public function store(VenueRequest $request)
    {
        $request->validated();

        Venue::create([
            'name' => $request->input('name'),
            'sport_type_id' => $request->input('sport_type_id'),
            'size' => $request->input('size'),
            'photo' => $request->file('photo')->store('venues'),
            'description' => $request->input('description'),
        ]);

        return response()->noContent();
    }

    public function show(Venue $venue)
    {
        $venue->load('sportType');

        return new VenueResource($venue);
    }

    public function update(VenueRequest $request, Venue $venue)
    {
        $request->validated();

        $venue->update([
            'name' => $request->input('name'),
            'sport_type_id' => $request->input('sport_type_id'),
            'size' => $request->input('size'),
            'photo' => $request->file('venue')->store('venues'),
            'description' => $request->input('description'),
        ]);

        return response()->noContent();
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();

        return response()->noContent();
    }
}
