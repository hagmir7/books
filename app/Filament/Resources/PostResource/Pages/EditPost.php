<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make()
                ->color('success')
                ->icon('heroicon-o-plus-circle'),

            Actions\Action::make(__("View"))
                ->url(route('blog.show', $this->record->slug))
                ->openUrlInNewTab()
                ->color('info')
                ->icon('heroicon-o-rocket-launch'),

            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash'),
        ];

    }


}
