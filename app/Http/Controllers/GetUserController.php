<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Models\Reservation;
use App\Models\User;

class GetUserController extends Controller
{
    public function __invoke()
    {
        $user = [
            'user' => new UserResource(User::find(1)),
            'reservations' => ReservationResource::collection(Reservation::where('user_id', 1)->get()),
            'teams' => TeamResource::collection(User::find(1)->teams()->get()),
        ];

        return response()->json($user);
    }
}
