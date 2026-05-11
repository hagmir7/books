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

        $site = app('site');

        // Set locale
        if ($site && $site->language) {
            app()->setLocale($site->language->code);
        }

        /*
        |--------------------------------------------------------------------------
        | Build Clean URL
        |--------------------------------------------------------------------------
        |
        | Examples:
        |
        | https://dev.example.com      => https://example.com
        | http://localhost:8000       => http://localhost:8000
        | http://127.0.0.1:8000       => http://127.0.0.1:8000
        |
        */

        $scheme = $request->getScheme();

        $host = $request->getHost();

        $port = $request->getPort();

        // Remove dev. subdomain
        $host = preg_replace('/^dev\./', '', $host);

        // Detect localhost / 127.0.0.1
        $isLocal =
            $host === 'localhost' ||
            $host === '127.0.0.1';

        // Build URL
        $cleanUrl = $scheme . '://' . $host;

        // Add port only for local environments
        if ($isLocal && $port) {
            $cleanUrl .= ':' . $port;
        }

        // Set app url dynamically
        config([
            'app.url' => $cleanUrl,
        ]);

        // Share site globally
        View::share('site', $site);

        return $next($request);
    }
}
