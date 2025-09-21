<?php

namespace App\Filament\Resources\BookResource\Pages;


use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditBook extends EditRecord
{


    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {

        $actions = [
            Actions\CreateAction::make()
                ->url('/admin/books/create')
                ->icon('heroicon-o-plus-circle'),
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash'),

        ];
        return $actions;
    }

}
