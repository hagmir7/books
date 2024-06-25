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

    protected $except = [
        'book/store',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $domain = str_replace('www.', '', $request->getHost());
        dd($domain);
        $site = Site::where('domain', $domain)->firstOrFail();

        $currentUrl = request()->getSchemeAndHttpHost();

        config(['app.url' => $currentUrl]);

        $cookieName = 'o2s-chl';

        if (!Cookie::has($cookieName)) {
            $cookieValue = substr(base64_encode(random_bytes(24)), 0, 32);
            $minutes = 60; // Cookie duration in minutes

            // Set the cookie
            Cookie::queue($cookieName, $cookieValue, $minutes);
        }




        View::share('site', $site);
        return $next($request, compact('site'));
    }
}
