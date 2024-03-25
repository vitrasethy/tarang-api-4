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
        return new AmenityCollection(Amenity::with('venues')->get());
    }

    public function store(AmenityRequest $request)
    {
        return new AmenityResource(Amenity::create($request->validated()));
    }

    public function show(Amenity $amenity)
    {
        return new AmenityResource($amenity);
    }

    public function update(AmenityRequest $request, Amenity $amenity)
    {
        $amenity->update($request->validated());

        return new AmenityResource($amenity);
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();

        return response()->noContent();
    }
}
