<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListAuthors extends ListRecords
{

    protected static string $resource = AuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'ALL' => Tab::make()
                ->label(__("All"))
                ->icon("heroicon-o-wallet")
                ->modifyQueryUsing(fn(Builder $query) => $query->latest()),

            'ON_HOLD' => Tab::make()
                ->label(__("On hold"))
                ->icon("heroicon-o-clock")
                ->modifyQueryUsing(fn(Builder $query) => $query->where('verified', false)->latest()),
        ];
    }
}
