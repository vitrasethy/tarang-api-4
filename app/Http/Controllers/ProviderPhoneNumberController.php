<?php

namespace App\Http\Controllers;

use App\Notifications\SendSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ProviderPhoneNumberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "phone" => "required|string",
        ]);

        $user = auth()->user();
        try {
            $code = random_int(100000, 999999);
        } catch (\Exception $e) {
            $code = 123456;
        }

        $user->update([
            "phone" => $validated['phone'],
            "code" => $code,
        ]);

        Notification::send($user, new SendSMS($code));

        return response()->json([
            "message" => "Success",
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            "code" => "required|integer|digits:6",
        ]);

        $user = auth()->user();

        if ($user->code === $validated['code']) {
            $user->update([
                "is_verified" => 1,
            ]);
        } else {
            return response()->json([
                "message" => "'Code is not valid.'",
            ], 404);
        }

        return response()->json([
            "message" => "Success",
        ]);
    }
}
