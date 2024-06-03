<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestAuthAPI extends Controller
{
    public function login(Request $request)
    {
        if (! Auth::attempt([
            "phone" => $request->input('phone'),
            "password" => $request->input('password')
        ])){
            return response()->json([
                'message' => "Wrong credential.",
            ], 401);
        }

        $token = Auth::user()->createToken('testing');

        return response()->json([
            "token" => $token->plainTextToken,
        ]);
    }


}
