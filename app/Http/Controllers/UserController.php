<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
            'is_admin' => 1,
        ]);

        return response()->noContent();
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (! Auth::attempt($validated)) {
            throw ValidationException::withMessages([
                'phone' => __('auth.failed'),
            ]);
        }

        $token = $request->user()->createToken('mobile');

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }
}
