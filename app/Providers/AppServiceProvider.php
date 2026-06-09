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

        $site = null;

        if (app()->runningInConsole()) {
            $site = Site::first();
        } else {
            $host = request()->getHost();
            $domain = str_replace('www.', '', $host);
            $site = Site::where('domain', $domain)->first();
        }

        if (!$site) {
            $site = Site::first();
        }

        app()->instance('site', $site);

        $siteOptions = $site->site_options ?? [];

        if (isset($siteOptions['GITHUB_CLIENT_ID'], $siteOptions['GITHUB_CLIENT_SECRET'])) {
            config([
                'services.github.client_id'     => $siteOptions['GITHUB_CLIENT_ID'],
                'services.github.client_secret' => $siteOptions['GITHUB_CLIENT_SECRET'],
                'services.github.redirect'      => url('/auth/github/callback'),
            ]);
        }

        if (isset($siteOptions['GOOGLE_CLIENT_ID'], $siteOptions['GOOGLE_CLIENT_SECRET'])) {
            config([
                'services.google.client_id'     => $siteOptions['GOOGLE_CLIENT_ID'],
                'services.google.client_secret' => $siteOptions['GOOGLE_CLIENT_SECRET'],
                'services.google.redirect'      => url('/auth/google/callback'),
            ]);
        }

        if (isset($siteOptions['FACEBOOK_CLIENT_ID'], $siteOptions['FACEBOOK_CLIENT_SECRET'])) {
            config([
                'services.facebook.client_id'     => $siteOptions['FACEBOOK_CLIENT_ID'],
                'services.facebook.client_secret' => $siteOptions['FACEBOOK_CLIENT_SECRET'],
                'services.facebook.redirect'      => url('/auth/facebook/callback'),
            ]);
        }


    }
}
