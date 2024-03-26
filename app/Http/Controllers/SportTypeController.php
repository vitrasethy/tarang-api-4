<?php

namespace App\Http\Controllers;

use App\Http\Requests\SportTypeRequest;
use App\Http\Resources\SportTypeCollection;
use App\Http\Resources\SportTypeResource;
use App\Models\SportType;

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
        $sportType->delete();

        return response()->noContent();
    }
}
