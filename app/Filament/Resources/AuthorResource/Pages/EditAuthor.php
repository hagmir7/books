<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;

class EditAuthor extends EditRecord
{

    use HasRecordNavigation;
    protected static string $resource = AuthorResource::class;

    protected function getHeaderActions(): array
    {

        $actions = [
            Actions\DeleteAction::make(),
        ];
        return array_merge($actions, $this->getNavigationActions());
    }
}
