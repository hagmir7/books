<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
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
