<?php

namespace App\Filament\Resources\SiteSocials\Pages;

use App\Filament\Resources\SiteSocials\SiteSocialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiteSocial extends EditRecord
{
    protected static string $resource = SiteSocialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
