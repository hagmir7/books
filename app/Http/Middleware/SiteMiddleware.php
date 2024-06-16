<?php

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

class SiteMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->getHost();
        $site = Site::where('domain', $domain)->firstOrFail();

        $currentUrl = request()->getSchemeAndHttpHost();

        config(['app.url' => $currentUrl]);

        $response = $next($request);

        $sessionCookie = cookie('laravel_session');
        //$token = $request->session()->token();
        //$response->withCookie(cookie('XSRF-TOKEN', $token));
        $response->withCookie($sessionCookie);

        View::share('site', $site);
        return $next($request, compact('site'));
    }
}
