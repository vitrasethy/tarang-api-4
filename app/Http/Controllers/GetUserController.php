<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserResource;
use App\Models\Reservation;
use App\Models\User;

class GetUserController extends Controller
{
    public function __invoke()
    {
        $user = [
            'user' => new UserResource(User::find(auth()->id())),
            'reservations' => ReservationResource::collection(Reservation::where('user_id', auth()->id())->get()),
        ];

        return response()->json($user);
    }
}
