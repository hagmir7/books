<?php

namespace App\Filament\Resources\SiteResource\Pages;

use App\Filament\Resources\SiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditSite extends EditRecord
{
    protected static string $resource = SiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon(Heroicon::OutlinedPlusCircle)
                ->color('success'),
            Actions\Action::make('view')
                ->label(__("Launch"))
                ->color('info')
                ->icon(Heroicon::OutlinedRocketLaunch)
                ->url('https://' . $this->record->domain)
                ->openUrlInNewTab(),
            Actions\DeleteAction::make()
                ->icon(Heroicon::OutlinedTrash),
        ];
    }
}
