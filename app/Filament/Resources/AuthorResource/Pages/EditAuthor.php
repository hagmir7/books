<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuthor extends EditRecord
{

    protected static string $resource = AuthorResource::class;

    protected function getHeaderActions(): array
    {

        $actions = [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash'),
        ];
        return $actions;
    }
}
