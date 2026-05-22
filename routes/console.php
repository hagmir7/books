<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



Schedule::command('app:sync-data')
    ->everyMinute()
    ->runInBackground()        // runs as a separate process, won't block other tasks
    ->withoutOverlapping()     // skip if previous run is still going
    ->appendOutputTo(storage_path('logs/sync.log'));
