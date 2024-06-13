<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Notifications\SendSMS;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Notification;

class ProviderController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $providerUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate(
            [
                'name' => $providerUser->name,
            ],
            [
                'photo' => $providerUser->avatar,
            ]
        );

        Provider::updateOrCreate(
            [
                'provider_id' => $providerUser->id,
            ],
            [
                'user_id' => $user->id,
                'provider_token' => $providerUser->token,
            ]
        );

        Auth::login($user);

        if ($user->is_admin === 1) {
            return redirect('https://admin.tarang.site');
        }

        if ($user->phone === null) {
            return redirect('https://tarang.site/phone');
        }

        return redirect('https://tarang.site');
    }

    public function add_user_phone(Request $request)
    {
        $validated = $request->validate([
            "phone" => ['required', 'string', 'max:13', 'unique:' . User::class],
        ]);

        $user = auth()->user();

        try {
            $code = random_int(100000, 999999);
        } catch (\Exception $e) {
            $code = 123456;
        }

        $user->update([
            "phone" => $validated["phone"],
            "code" => $code,
        ]);

        Notification::send($user, new SendSMS($code));

        return response()->noContent();
    }
}
