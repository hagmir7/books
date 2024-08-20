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
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Model::preventLazyLoading(! app()->isProduction());
        $domain = str_replace('www.', '', request()->getHost());
        $site = Site::where('domain', $domain)->firstOrFail();
        app()->instance('site', $site);

    }
}
