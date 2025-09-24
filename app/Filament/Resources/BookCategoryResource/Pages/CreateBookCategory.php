<?php

namespace App\Filament\Resources\BookCategoryResource\Pages;

use App\Filament\Resources\BookCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookCategory extends CreateRecord
{
    protected static string $resource = BookCategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['language_id'] = app("site")->language_id;
        return $data;
    }
}
