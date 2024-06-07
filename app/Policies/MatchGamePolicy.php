<?php

namespace App\Policies;

use App\Models\MatchGame;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MatchGamePolicy
{
    use HandlesAuthorization;

    public function update(User $user, MatchGame $matchGame): bool
    {
        return $user->is_admin === true || $matchGame->reservation->user_id !== auth()->id();
    }

    public function delete(User $user, MatchGame $matchGame): bool
    {
        return $user->is_admin === true || $user->id === $matchGame->reservation->user_id;
    }
}
