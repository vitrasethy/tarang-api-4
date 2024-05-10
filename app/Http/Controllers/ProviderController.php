<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
            ]
        );

        $provider = Provider::updateOrCreate(
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
            return redirect(config('app.frontend_url').'/admin');
        }

        return redirect(config('app.frontend_url'));
    }
}
