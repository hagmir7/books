<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncData extends Command
{
    protected $signature   = 'app:sync-data';
    protected $description = 'Runs every minute in the background';

    public function handle(): void
    {
        Log::info('SyncData started', ['time' => now()->toDateTimeString()]);

        try {
            // your logic here
            // e.g. DB::table('orders')->where(...)->update([...]);

            Log::info('SyncData finished successfully');
        } catch (\Exception $e) {
            Log::error('SyncData failed', ['error' => $e->getMessage()]);
        }
    }
}
