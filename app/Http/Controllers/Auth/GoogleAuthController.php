<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            if (empty($googleUser->email)) {
                return redirect('/login')
                    ->withErrors(__('No email returned from Google account.'));
            }

            $user = User::where('provider_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if (! $user) {
                $user = User::create($this->buildUserData($googleUser));
            } elseif (! $user->provider_id) {
                $user->update([
                    'provider_id' => $googleUser->id,
                    'provider'    => 'google',
                ]);
            }

            $user->update(['last_login' => now()]);

            Auth::login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Google OAuth Error', ['message' => $e->getMessage()]);

            return redirect('/login')
                ->withErrors(__('Google authentication failed.'));
        }
    }

    private function buildUserData(object $googleUser): array
    {
        [$firstName, $lastName] = $this->parseName($googleUser->name);

        return [
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'email'       => $googleUser->email,
            'provider_id' => $googleUser->id,
            'provider'    => 'google',
            'avatar'      => $googleUser->avatar,
            'password'    => bcrypt(Str::random(24)),
        ];
    }

    private function parseName(?string $name): array
    {
        $parts = array_filter(explode(' ', trim((string) $name)));

        if (count($parts) < 2) {
            return [$name, ''];
        }

        $firstName = array_shift($parts);
        $lastName  = implode(' ', $parts);

        return [$firstName, $lastName];
    }
}
