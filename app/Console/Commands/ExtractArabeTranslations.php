<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class ExtractArabeTranslations extends Command
{
    protected $signature = 'translations:extract-ar';
    protected $description = 'Extract translations from views and PHP files';

    public function handle()
    {
        $translationFile = resource_path('lang/ar.json');

        // Existing translations
        $existingTranslations = json_decode(File::get($translationFile), true) ?? [];

        // Patterns to match translation calls
        $patterns = [
            '/(?:__|trans)\([\'"](.+?)[\'"]\)/',  // __() and trans()
            '/@lang\([\'"](.+?)[\'"]\)/',         // Blade @lang directive
            '/@choice\([\'"](.+?)[\'"]\,/'        // @choice translations
        ];

        $newTranslations = $this->scanForTranslations($patterns, $existingTranslations);

        // Only add translations that don't already exist
        $finalTranslations = array_merge($existingTranslations, $newTranslations);

        // Sort keys alphabetically
        ksort($finalTranslations);

        // Save translations
        File::put(
            $translationFile,
            json_encode($finalTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // Provide feedback about new translations
        $newKeysCount = count($newTranslations);
        $this->info("Extracted {$newKeysCount} new translation keys successfully!");
    }

    protected function scanForTranslations($patterns, $existingTranslations)
    {
        $newTranslations = [];
        $directories = [
            resource_path('views'),
            app_path(),
            resource_path('js'),
            // Add more directories to scan
        ];

        foreach ($directories as $directory) {
            if (!is_dir($directory)) continue;

            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($directory)
            );

            $phpFiles = new RegexIterator($files, '/\.(php|vue|js)$/');

            foreach ($phpFiles as $file) {
                $content = file_get_contents($file->getPathname());

                foreach ($patterns as $pattern) {
                    preg_match_all($pattern, $content, $matches);

                    foreach ($matches[1] as $key) {
                        // Trim and clean the key
                        $key = trim($key);

                        // Only add if:
                        // 1. Not empty
                        // 2. Not already in existing translations
                        // 3. Not already in new translations
                        if (
                            !empty($key)
                            && !isset($existingTranslations[$key])
                            && !isset($newTranslations[$key])
                        ) {
                            $newTranslations[$key] = $key; // Default to English key
                        }
                    }
                }
            }
        }

        return $newTranslations;
    }
}
