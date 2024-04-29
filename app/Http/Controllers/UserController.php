<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function setAdmin(Request $request)
    {
    }
}
