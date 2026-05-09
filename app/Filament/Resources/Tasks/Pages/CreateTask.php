<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;


    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['site_id'] = app('site')->id;
        $data['user_id'] = auth()->id();
        return $data;
    }
}
