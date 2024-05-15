<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = Team::with(['sportType', 'users']);

        if ($request->type) {
            $type = $request->type;
            $query
                ->where('sport_type_id', $type)
                ->orWhereHas('sportType', function ($query) use ($type) {
                    $query->where('name', $type);
                });
        }

        if ($request->has('user')) {
            $query->whereHas('users', function (Builder $query) {
                $query->where('users.id', auth()->id());
            });
        }

        // $teams = $request->has('pagination')
        //     ? $query->paginate(5)`
        //     : $query->get();
        $teams = $query->paginate(5);

        return new TeamCollection($teams);
    }

    public function store(TeamRequest $request)
    {
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
        $team->delete();

        return response()->noContent();
    }
}
