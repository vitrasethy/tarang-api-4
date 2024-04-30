<?php

namespace App\Http\Controllers;

use App\Http\Requests\SportTypeRequest;
use App\Http\Resources\SportTypeCollection;
use App\Http\Resources\SportTypeResource;
use App\Models\SportType;
use App\Models\Team;
use App\Models\Venue;

class SportTypeController extends Controller
{
    public function index()
    {
        $sportTypes = SportType::all();

        return new SportTypeCollection($sportTypes);
    }

    public function store(SportTypeRequest $request)
    {
        $validated = $request->validated();

        SportType::create($validated);

        return response()->noContent();
    }

    public function show(SportType $sportType)
    {
        return new SportTypeResource($sportType);
    }

    public function update(SportTypeRequest $request, SportType $sportType)
    {
        $validated = $request->validated();

        $sportType->update($validated);

        return response()->noContent();
    }

    public function destroy(SportType $sportType)
    {
        if (
            Team::where('sport_type_id', $sportType)->exists() ||
            Venue::where('sport_type_id', $sportType)->exists()
        ) {
            return response("Can't Delete", 404);
        }

        $sportType->delete();

        return response()->noContent();
    }
}
