<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GithubAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        try {
            $githubUser = Socialite::driver('github')->stateless()->user();

            $user = User::where('provider_id', $githubUser->id)
                ->orWhere('email', $githubUser->email)
                ->first();

            if (! $user) {
                $user = User::create($this->buildUserData($githubUser));
            } elseif (! $user->provider_id) {
                $user->update([
                    'provider_id' => $githubUser->id,
                    'provider'    => 'github',
                ]);
            }

            $user->update(['last_login' => now()]);

            Auth::login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('GitHub OAuth Error', ['message' => $e->getMessage()]);

            return redirect()->route('login')
                ->withErrors(__('GitHub authentication failed.'));
        }
    }

    private function buildUserData(object $githubUser): array
    {
        [$firstName, $lastName] = $this->parseName($githubUser->name ?? $githubUser->nickname);

        return [
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'email'       => $githubUser->email,
            'provider_id' => $githubUser->id,
            'provider'    => 'github',
            'avatar'      => $githubUser->avatar,
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
