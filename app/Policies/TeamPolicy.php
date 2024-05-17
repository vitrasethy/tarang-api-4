<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;

class TeamPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {

    }

    public function view(User $user, Team $team)
    {
    }

    public function create(User $user): bool
    {
        $teams = Team::with('users')->whereHas('users', function (Builder $query) {
            $query->where('users.id', auth()->id());
        })->count();

        return $teams <= 2;
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
