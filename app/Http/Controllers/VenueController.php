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
        $venues = Venue::with(['sportType', 'amenities'])->when($request, function (Builder $query, $filter) {
            if ($filter->type)
                $query->where('sport_type_id', $filter->type)->orWhereHas('sportType', function ($query) use ($filter) {
                    $query->where('name', $filter->type);
            });
            if ($filter->amenity)
                $query->where('sport_type_id', $filter->amenity)->orWhereHas('sportType', function ($query) use ($filter) {
                    $query->where('name', $filter->amenity);
                });
        })->get();

        return new VenueCollection($venues);
    }

    public function store(VenueRequest $request)
    {
        $request->validated();

        $venue = Venue::create([
            ...$request->except('amenity_id'),
        ]);

        $venue->amenities()->attach($request->input('amenity_id'));

        return new VenueResource($venue);
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
