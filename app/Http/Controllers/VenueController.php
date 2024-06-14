<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Http\Resources\VenueCollection;
use App\Http\Resources\VenueResource;
use App\Models\Reservation;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Venue::with(['sportType', 'amenities']);
        $filterKey = '';
        $filterValue = '';

        if ($request->filled('type')) {
            $filterKey = 'type';
            $filterValue = $request->type;
            $query->where(function ($q) use ($filterValue) {
                $q->where('sport_type_id', $filterValue)
                    ->orWhereHas('sportType', function ($query) use ($filterValue) {
                        $query->where('name', $filterValue);
                    });
            });
        }

        if ($request->filled('amenity')) {
            $filterKey = 'amenity';
            $filterValue = $request->amenity;
            $query->whereHas('amenities', function ($query) use ($filterValue) {
                $query->where('amenities.id', $filterValue);
            });
        }

        $venues = $request->has('all')
            ? $query->get()
            : $query->paginate(6)->appends([$filterKey => $filterValue]);

        return new VenueCollection($venues);
    }

    public function store(VenueRequest $request)
    {
        Gate::authorize('admin', Venue::class);

        $request->validated();

        $venue = Venue::create([
            ...$request->except('amenity_id'),
        ]);

        $venue->amenities()->attach($request->input('amenity_id'));

        return new VenueResource($venue);
    }

    public function show(Venue $venue)
    {
        $venue->load(['sportType', 'amenities']);

        return new VenueResource($venue);
    }

    public function update(VenueRequest $request, Venue $venue)
    {
        Gate::authorize('admin', Venue::class);

        $request->validated();

        $venue->update([
            ...$request->except('amenity_id'),
        ]);

        $venue->amenities()->sync($request->input('amenity_id'));

        return response()->noContent();
    }

    public function destroy(Venue $venue)
    {
        Gate::authorize('admin', Venue::class);

        if (Reservation::where('venue_id', $venue->id)->exists()) {
            return response("Can't delete.", 403);
        }

        $venue->delete();

        return response()->noContent();
    }

    public function report()
    {
        Gate::authorize('admin', Venue::class);

        return response()->json([
            "count" => Venue::count(),
        ]);
    }
}
