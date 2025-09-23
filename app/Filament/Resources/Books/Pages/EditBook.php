<?php

namespace App\Filament\Resources\Books\Pages;

use App\Filament\Resources\Books\BookResource;
use Filament\Actions\Action;
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
            Action::make(__("Launch"))->icon(Heroicon::OutlinedRocketLaunch)
                ->color('warning')
                ->url(route('book.show', $this->record->slug), true),
            CreateAction::make()->icon(Heroicon::OutlinedPlusCircle)->color('success'),
            DeleteAction::make()->icon(Heroicon::OutlinedTrash),
            ViewAction::make()->icon(Heroicon::OutlinedViewfinderCircle),
            ForceDeleteAction::make()->icon(Heroicon::OutlinedTrash),
            RestoreAction::make()->icon(Heroicon::OutlinedPencilSquare),

        ];
    }
}
