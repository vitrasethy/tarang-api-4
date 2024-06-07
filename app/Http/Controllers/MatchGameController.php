<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchGameRequest;
use App\Http\Resources\MatchGameResource;
use App\Models\MatchGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MatchGameController extends Controller
{
    public function index(Request $request)
    {
        $matchGames = MatchGame::with(['reservation.venue', 'users']);

        if ($request->has('user')) {
            $matchGames->where('user1_id', auth()->id())->orWhere('user2_id', auth()->id());

            return MatchGameResource::collection($matchGames->paginate(5));
        }

        return MatchGameResource::collection($matchGames->paginate(5));
    }

    public function store(MatchGameRequest $request)
    {
        $validated = $request->validated();

        $match_game = MatchGame::create($validated);

        $match_game->users()->attach(auth()->id());

        return response()->noContent();
    }

    public function show(MatchGame $matchGame)
    {
        $matchGame->load(['reservation', 'users']);

        return new MatchGameResource($matchGame);
    }

    public function update(MatchGameRequest $request, MatchGame $matchGame)
    {
        Gate::authorize('update', MatchGame::class);

        $validated = $request->validated();

        $matchGame->update($validated);

        $matchGame->users()->attach(auth()->id());

        return response()->noContent();
    }

    public function destroy(MatchGame $matchGame)
    {
        Gate::authorize('delete', $matchGame);

        $matchGame->delete();

        return response()->noContent();
    }
}
