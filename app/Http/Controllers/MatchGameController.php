<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchGameRequest;
use App\Http\Resources\MatchGameResource;
use App\Models\MatchGame;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MatchGameController extends Controller
{
    public function index(Request $request)
    {
        $matchGames = MatchGame::with([
            'reservation.venue',
            'team1.sportType',
            'team2.sportType',
            'team1.users',
            'team2.users',
        ]);

        if ($request->has('user')) {
            $matchGames->whereHas('team1.users', function (Builder $builder) {
                $builder->where('users.id', auth()->id());
            })->orWhereHas('team2.users', function (Builder $builder) {
                $builder->where('users.id', auth()->id());
            });
            return MatchGameResource::collection($matchGames->paginate(5));
        }

        return MatchGameResource::collection($matchGames->paginate(5));
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
        Gate::authorize('update', MatchGame::class);

        $validated = $request->validated();

        $matchGame->update($validated);

        return response()->noContent();
    }

    public function destroy(MatchGame $matchGame)
    {
        Gate::authorize('delete', $matchGame);

        $matchGame->delete();

        return response()->noContent();
    }
}
