<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchGameRequest;
use App\Http\Resources\MatchGameCollection;
use App\Http\Resources\MatchGameResource;
use App\Models\MatchGame;

class MatchGameController extends Controller
{
    public function index()
    {
        $matchGames = MatchGame::with(['reservation', 'team'])->get();

        return new MatchGameCollection($matchGames);
    }

    public function store(MatchGameRequest $request)
    {
        $validated = $request->validated();

        MatchGame::create($validated);

        return response()->noContent();
    }

    public function show(MatchGame $matchGame)
    {
        $matchGame->load(['reservation', 'team']);

        return new MatchGameResource($matchGame);
    }

    public function update(MatchGameRequest $request, MatchGame $matchGame)
    {
        $validated = $request->validated();

        $matchGame->update($validated);

        return response()->noContent();
    }

    public function destroy(MatchGame $matchGame)
    {
        $matchGame->delete();

        return response()->noContent();
    }
}
