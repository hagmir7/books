<?php

namespace App\Providers;

use App\Models\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Model::preventLazyLoading(! app()->isProduction());

        // Default site (safe fallback for CLI / queue)
        $site = null;

        if (app()->runningInConsole()) {
            $site = Site::first(); // fallback for artisan/queue
        } else {
            $host = request()->getHost();
            $domain = str_replace('www.', '', $host);

            $site = Site::where('domain', $domain)->first();
        }

        // fallback protection
        if (!$site) {
            $site = Site::first();
        }

        app()->instance('site', $site);
    }
}
