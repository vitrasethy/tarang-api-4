<?php

namespace App\Policies;

use App\Models\SportType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SportTypePolicy
{
    use HandlesAuthorization;

    public function CreateUpdateDelete(User $user): bool
    {
        return $user->is_admin === true;
    }
}
