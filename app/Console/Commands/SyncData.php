<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncData extends Command
{
    protected $signature   = 'app:sync-data';
    protected $description = 'Runs every minute in the background';

    public function handle(): void
    {
        Log::info('SyncData started', ['time' => now()->toDateTimeString()]);

        try {
            // ── 1. Load scrap.json ───────────────────────────────────────────
            $jsonPath = base_path('scrap.json');

            if (! file_exists($jsonPath)) {
                Log::error('SyncData: scrap.json not found at ' . $jsonPath);
                return;
            }

            $config = json_decode(file_get_contents($jsonPath), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('SyncData: Invalid JSON in scrap.json — ' . json_last_error_msg());
                return;
            }

            $start = $config['aseeralkotb']['start'];
            $end   = $config['aseeralkotb']['end'];

            Log::info('SyncData: loaded scrap.json', ['start' => $start, 'end' => $end]);

            // ── 2. Send the request ──────────────────────────────────────────
            $response = Http::timeout(60)
                ->withOptions([
                    'verify' => false, // disable SSL check (for testing only)
                ])
                ->get('https://api.facepy.com/en/aseeralkotb', [
                    'start' => $start,
                    'end'   => $end,
                ]);

            if ($response->failed()) {
                Log::warning('SyncData: Request failed — scrap.json not updated', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return;
            }

            // ── 3. Success — increment and save ──────────────────────────────
            $config['aseeralkotb']['start'] = $start + 10;
            $config['aseeralkotb']['end']   = $end   + 10;

            file_put_contents(
                $jsonPath,
                json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            Log::info('SyncData finished successfully', [
                'new_start' => $config['aseeralkotb']['start'],
                'new_end'   => $config['aseeralkotb']['end'],
            ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('SyncData failed: Connection error', ['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            Log::error('SyncData failed', ['error' => $e->getMessage()]);
        }
    }
}
