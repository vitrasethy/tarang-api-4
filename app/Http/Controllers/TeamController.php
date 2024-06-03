<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', auth()->id());

        $query = Team::with(['sportType', 'users']);

        if ($request->filled('type')) {
            $type = $request->type;
            $query->where('sport_type_id', $type)
                ->orWhereHas('sportType', function ($query) use ($type) {
                    $query->where('name', $type);
                });
        }

        if ($request->has('user')) {
            $query->whereHas('users', function (Builder $query) {
                $query->where('users.id', auth()->id());
            });
        }

        $teams = $request->has('all')
            ? $query->get()
            : $query->paginate(5);

        return new TeamCollection($teams);
    }

    public function store(TeamRequest $request)
    {
//        Gate::authorize('create');

        $team = Team::create($request->validated());

        $team->users()->attach(auth()->id());

        return new TeamResource($team);
    }

    public function show(Team $team)
    {
        $team->load('sportType');

        return new TeamResource($team);
    }

    public function update(TeamRequest $request, Team $team)
    {
        $team->update($request->validated());

        return new TeamResource($team);
    }

    public function destroy(Team $team)
    {
        if ($team->matchGames()->exists()){
            return response()->json([
                'message' => 'This team is in Match Game.'
            ], 403);
        }

        $team->delete();

        return response()->noContent();
    }
}
