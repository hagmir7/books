<?php

namespace App\Filament\Resources\Books\Pages;

use App\Filament\Resources\Books\BookResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->icon(Heroicon::OutlinedViewfinderCircle),
            CreateAction::make()->icon(Heroicon::OutlinedPlusCircle)->color('success'),
            DeleteAction::make()->icon(Heroicon::OutlinedTrash),
            ForceDeleteAction::make()->icon(Heroicon::OutlinedTrash),
            RestoreAction::make()->icon(Heroicon::OutlinedPencilSquare),
        ];
    }
}
