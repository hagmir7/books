<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

class SiteMiddleware
{
    protected $except = [
        'book/store',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $site = app("site");
        app()->setLocale($site->language->code);
        $currentUrl = request()->getSchemeAndHttpHost();
        // config(['app.locale' => ]);
        config(['app.url' => str_replace('dev', '', $currentUrl)]);

        View::share('site', $site);
        return $next($request);
    }
}
