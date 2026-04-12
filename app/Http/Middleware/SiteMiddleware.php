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
        // Skip middleware for excluded routes
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return $next($request);
            }
        }

        $site = app("site");

        if ($site && $site->language) {
            app()->setLocale($site->language->code);
        }

        // Use request instance instead of helper
        $currentUrl = $request->getSchemeAndHttpHost();

        // Remove "dev." safely
        $cleanUrl = preg_replace('/^https?:\/\/dev\./', $request->getScheme() . '://', $currentUrl);

        config(['app.url' => $cleanUrl]);

        // Share site globally in views
        View::share('site', $site);

        return $next($request);
    }
}
