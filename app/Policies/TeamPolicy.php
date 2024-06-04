<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class TeamPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $teams = Team::with('users')->whereHas('users', function (Builder $query) use ($user) {
            $query->where('users.id', $user->id);
        })->count();

        return $teams < 2;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateDelete(User $user, Team $team): bool
    {
        return $team->users->contains('id', $user->id) || $user->is_admin === true;
    }
}
