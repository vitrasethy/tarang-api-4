<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization;

    public function viewAdmin(User $user): bool
    {
        return $user->is_admin === true;
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $user->is_admin === true || $user->id === $reservation->user_id;
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->is_admin === true || $user->id === $reservation->user_id;
    }
}
