<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // if ($request->segment(1)) {
        //     App::setLocale($request->segment(1));
        // }
        return $next($request);
    }
}
