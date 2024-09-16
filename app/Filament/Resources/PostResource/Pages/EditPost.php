<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;

class EditPost extends EditRecord
{

    use HasRecordNavigation;
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {

        $actions = [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash'),
        ];
        return array_merge($actions, $this->getNavigationActions());
    }


}
