<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Http\Resources\VenueCollection;
use App\Http\Resources\VenueResource;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::with('sportType')->get();

        return new VenueCollection($venues);
    }

    public function store(VenueRequest $request)
    {
        $request->validated();

        $venue = Venue::create([
            ...$request->except('amenity_id'),
            'photo' => $request->file('photo')->store('venues'),
        ]);

        $venue->amenities()->attach($request->input('amenity_id'));

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
            ...$request->except('amenity_id'),
            'photo' => $request->file('photo')->store('venues'),
        ]);

        $venue->amenities()->sync($request->input('amenity_id'));

        return response()->noContent();
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();

        return response()->noContent();
    }
}
