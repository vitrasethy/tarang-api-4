<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Team $team)
    {
    }

    public function create(User $user): Response
    {
        $teams = Team::with('users')->whereHas('users', function (Builder $query) use ($user) {
            $query->where('users.id', auth()->id());
        })->count();

        return $teams <= 2
            ? Response::allow()
            : Response::deny('You already create 2 teams. No more.');
    }

    public function update(User $user, Team $team)
    {
    }

    public function delete(User $user, Team $team)
    {
    }

    public function restore(User $user, Team $team)
    {
    }

    public function forceDelete(User $user, Team $team)
    {
    }
}
