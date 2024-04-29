<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Http\Resources\VenueCollection;
use App\Http\Resources\VenueResource;
use App\Models\Reservation;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $venues = Venue::with('sportType')->when($request->type, function (Builder $query, $type) {
            $query->where('sport_type_id', $type)->orWhereHas('sportType', function ($query) use ($type) {
                $query->where('name', $type);
            });
        })->get();

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

    public function update(Request $request, Venue $venue)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'size' => ['required', 'integer'],
            'photo' => ['sometimes', 'image'],
            'description' => ['nullable', 'string'],
            'sport_type_id' => 'required|exists:sport_types,id',
            'amenity_id.*' => 'required|exists:amenities,id'
        ]);

        $venue->update([
            ...$request->except('amenity_id'),
            'photo' => $request->file('photo')->store('venues'),
        ]);

        $venue->amenities()->sync($request->input('amenity_id'));

        return response()->noContent();
    }

    public function destroy(Venue $venue)
    {
        if (Reservation::where('venue_id', $venue->id)->exists()) {
            return response("Can't delete.", 403);
        }

        $venue->delete();

        return response()->noContent();
    }
}
