<?php

namespace App\Filament\Resources\Books\Pages;

use App\Filament\Resources\Books\BookResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        $data['type'] = "PDF";
        $data['site_id'] = app('site')->id;
        $data['language_id'] = app("site")->language->id;

        // Handle file processing
        if (isset($data['file']) && Storage::exists("public/" . $data['file'])) {
            $file_size = Storage::size("public/" . $data['file']);
            $file_path = Storage::path("public/" . $data['file']);

            $data['size'] = $this->formatFileSize($file_size);

            // Only try to parse PDF if we need to get page count
            if ($data['pages'] === "") {
                try {
                    $parser = new Parser();
                    $pdf = $parser->parseFile($file_path);
                    $data['pages'] = count($pdf->getPages());
                } catch (\Exception $e) {
                    Notification::make()
                        ->danger()
                        ->title("File is not supported!")
                        ->send();
                }
            }
        } else {
            Notification::make()
                ->danger()
                ->title("File not found!")
                ->send();
        }

        // Set title based on language
        switch (app("site")->language->code) {
            case "en":
                $data['title'] = "Download {$data['name']} for Free (PDF)";
                break;
            case "fr":
                $data['title'] = "Télécharger {$data['name']} gratuit (PDF)";
                break;
            case "ar":
                $data['title'] = "تحميل كتاب {$data['name']} مجانا (PDF)";
                break;
        }

        return $data;
    }

    protected function formatFileSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }
}
