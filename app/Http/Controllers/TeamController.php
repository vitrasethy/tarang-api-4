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
        return new TeamCollection(Team::with(['sportType', 'users'])->when($request->type,
            function (Builder $query, $type) {
                $query->where('sport_type_id', $type)->orWhereHas('sportType', function ($query) use ($type) {
                    $query->where('name', $type);
                });
            })->get());
    }

    public function store(TeamRequest $request)
    {
        $team = Team::create([
            ...$request->validated(),
            'logo' => $request->hasFile('logo') ? $request->file('logo')->store('logos') : null,
        ]);

        $team->users()->attach(1);

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

        return response()->noContent();
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return response()->noContent();
    }
}
