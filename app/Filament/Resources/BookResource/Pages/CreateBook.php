<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use App\Models\Language;
use App\Models\Site;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;



    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;

        $file_size = Storage::size("public\\" . $data['file']);
        $file_path =  Storage::path("public\\" . $data['file']);
        $parser = new Parser();
        try{
            $pdf = $parser->parseFile($file_path);
            $data['pages'] = count($pdf->getPages());
        }catch(\Exception $e){
            Notification::make()
                ->danger()
                ->title("File is not supported!")
                ->send();
        }
        $data['type'] = "PDF";
        $data['size'] = $this->formatFileSize($file_size);

        $language = Language::find($data['language_id']);

        switch($language->code){
            case "en":
                $data['title'] = "Download {$data['name']}  for Free (PDF)";
                break;
            case "fr":
                $data['title'] = "Télécharger {$data['name']} gratuit (PDF)";
                break;
            case "ar":
                $data['title'] = "تحميل كتاب {$data['name']} مجانا (PDF)";
                break;
        }

        // Add site_id
        $domain = str_replace('www.', '', request()->getHost());
        $site = Site::where('domain', $domain)->firstOrFail();
        $data['site_id'] = $site->id;
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
