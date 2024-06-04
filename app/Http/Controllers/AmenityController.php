<?php

namespace App\Http\Controllers;

use App\Http\Requests\AmenityRequest;
use App\Http\Resources\AmenityCollection;
use App\Http\Resources\AmenityResource;
use App\Models\Amenity;
use App\Models\Venue;
use Illuminate\Support\Facades\Gate;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::with('venues')->get();

        return new AmenityCollection($amenities);
    }

    public function store(AmenityRequest $request)
    {
        Gate::authorize('admin', Amenity::class);

        $validated = $request->validated();

        $amenities = Amenity::create($validated);

        return new AmenityResource($amenities);
    }

    public function show(Amenity $amenity)
    {
        return new AmenityResource($amenity);
    }

    public function update(AmenityRequest $request, Amenity $amenity)
    {
        Gate::authorize('admin', Amenity::class);

        $validated = $request->validated();

        $amenity->update($validated);

        return new AmenityResource($amenity);
    }

    public function destroy(Amenity $amenity)
    {
        Gate::authorize('admin', Amenity::class);

        if ($amenity->venues()->exists()) {
            return response()->json([
                "message" => "Can't delete amenity because this amenity associate with venues"
            ], 403);
        }

        $amenity->delete();

        return response()->noContent();
    }
}
