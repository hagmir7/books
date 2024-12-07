<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['site_id'] = app('site')->id;
        if(!$data['user_id']){
            $data['user'] = auth()->id();
        }
        return $data;
    }
}