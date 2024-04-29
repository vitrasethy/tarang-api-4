<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function setAdmin(UserRequest $request)
    {
        $request->validated();

        User::find($request->user_id)->update([
            'is_admin' => 1
        ]);

        return response()->noContent();
    }
}
