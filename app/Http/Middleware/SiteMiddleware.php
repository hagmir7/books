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
            $cookieValue = Str::random(32);
            $minutes = 60;
            Cookie::queue($cookieName, $cookieValue);
        }


        View::share('site', $site);
        return $next($request, compact('site'));
    }
}
