<?php

namespace App\Policies;

use App\Models\Amenity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AmenityPolicy
{
    use HandlesAuthorization;

    public function admin(User $user): bool
    {
        return $user->is_admin === true;
    }
}
