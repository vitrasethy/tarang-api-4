<?php

namespace App\Policies;

use App\Models\SportType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SportTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SportType $sportType): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SportType $sportType): bool
    {
        return true;
    }

    public function delete(User $user, SportType $sportType): bool
    {
        return true;
    }

    public function restore(User $user, SportType $sportType): bool
    {
        return true;
    }

    public function forceDelete(User $user, SportType $sportType): bool
    {
        return true;
    }
}
