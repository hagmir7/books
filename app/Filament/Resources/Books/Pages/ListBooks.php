<?php

namespace App\Filament\Resources\Books\Pages;

use App\Filament\Resources\Books\BookResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                // ->color('success')
                ->icon(Heroicon::OutlinedPlusCircle),
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

            'COPYRIGHT' => Tab::make()
                ->label(__("Copyright"))
                ->icon("heroicon-o-no-symbol")
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('copyright_date')->latest()),

        ];
    }
}
