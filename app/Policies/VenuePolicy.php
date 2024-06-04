<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VenuePolicy
{
    use HandlesAuthorization;

    public function admin(User $user): bool
    {
        return $user->is_admin === true;
    }
}
