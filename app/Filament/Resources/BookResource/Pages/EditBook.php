<?php

namespace App\Filament\Resources\BookResource\Pages;


use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;


class EditBook extends EditRecord
{

    use HasRecordNavigation;


    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {

        $existingActions = [
            Actions\DeleteAction::make(),
        ];
        return array_merge($existingActions, $this->getNavigationActions());
    }

}
