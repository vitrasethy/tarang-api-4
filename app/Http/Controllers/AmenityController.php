<?php

namespace App\Http\Controllers;

use App\Http\Requests\AmenityRequest;
use App\Http\Resources\AmenityCollection;
use App\Http\Resources\AmenityResource;
use App\Models\Amenity;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::with('venues')->get();

        return new AmenityCollection($amenities);
    }

    public function store(AmenityRequest $request)
    {
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
        $validated = $request->validated();

        $amenity->update($validated);

        return new AmenityResource($amenity);
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();

        return response()->noContent();
    }
}
