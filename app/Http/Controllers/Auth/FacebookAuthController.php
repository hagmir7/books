<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{


    public function redirect()
    {
        return Socialite::driver('facebook')
            ->scopes(['email', 'public_profile'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $email = $facebookUser->email
                ?? "{$facebookUser->id}@facebook-user.local";

            $user = User::where('provider_id', $facebookUser->id)
                ->orWhere('email', $email)
                ->first();

            if (! $user) {
                $user = User::create($this->buildUserData($facebookUser, $email));
            } elseif (! $user->provider_id) {
                $user->update([
                    'provider_id' => $facebookUser->id,
                    'provider'    => 'facebook',
                ]);
            }

            $user->update(['last_login' => now()]);

            Auth::login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Facebook OAuth Error', ['message' => $e->getMessage()]);

            return redirect()->route('login')
                ->withErrors(__('Facebook authentication failed.'));
        }
    }

    private function buildUserData(object $facebookUser, string $email): array
    {
        [$firstName, $lastName] = $this->parseName($facebookUser->name ?? 'Facebook User');

        return [
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'email'       => $email,
            'provider_id' => $facebookUser->id,
            'provider'    => 'facebook',
            'avatar'      => $facebookUser->avatar,
            'password'    => bcrypt(Str::random(24)),
        ];
    }

    private function parseName(?string $name): array
    {
        $parts = array_filter(explode(' ', trim((string) $name)));

        if (count($parts) < 2) {
            return [$name, null];
        }

        $firstName = array_shift($parts);
        $lastName  = implode(' ', $parts);

        return [$firstName, $lastName];
    }
}
