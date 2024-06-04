<?php

namespace App\Policies;

use App\Models\MatchGame;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MatchGamePolicy
{
    use HandlesAuthorization;

    public function update(User $user): bool
    {
        return $user->is_admin === true;
    }

    public function delete(User $user, MatchGame $matchGame): bool
    {
        return $user->is_admin === true || $user->id === $matchGame->reservation->user_id;
    }
}
