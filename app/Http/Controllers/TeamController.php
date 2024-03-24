<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        return TeamResource::collection(Team::with('sportType')->get());
    }

    public function store(TeamRequest $request)
    {
        $team = Team::create([
            ...$request->validated(),
            'logo' => $request->file('logo')->store('logos'),
        ]);

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
