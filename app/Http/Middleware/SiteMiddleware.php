<?php

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class SiteMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->getHost();
        $site = Site::where('domain', $domain)->firstOrFail();

        $currentUrl = request()->getSchemeAndHttpHost();

        config(['app.url' => $currentUrl]);

        $cookieName = 'o2s-chl';

        if (!Cookie::has($cookieName)) {
            $cookieValue = Str::random(32); // Generate a random 32-character string
            $minutes = 60; // Cookie duration in minutes

            // Set the cookie
            Cookie::queue($cookieName, $cookieValue, $minutes);

            session()->flash('message', 'Cookie has been set.');
        } else {
            session()->flash('message', 'Cookie already exists.');
        }


        View::share('site', $site);
        return $next($request, compact('site'));
    }
}
