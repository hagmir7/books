<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->icon(Heroicon::OutlinedTrash),
            Actions\CreateAction::make()
                ->icon(Heroicon::OutlinedPlusCircle)
                ->color('success')
        ];
    }
}
