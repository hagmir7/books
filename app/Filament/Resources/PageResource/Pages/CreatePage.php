<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Parsedown;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {


        if ($data['markdown']) {
            $parsedown = new Parsedown();
            $data['body'] = $parsedown->text($data['body']);
        }
        $data['user_id'] = auth()->user()->id;
        return $data;
    }
}
