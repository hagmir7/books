<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JoseEspinal\RecordNavigation\Traits\HasRecordsList;
use Filament\Resources\Components\Tab;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListBooks extends ListRecords
{

    use HasRecordsList;
    protected static string $resource = BookResource::class;


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

            'COPYRIGHT' => Tab::make()
                ->label(__("Copyright"))
                ->icon("heroicon-o-no-symbol")
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('copyright_date')->latest()),

        ];
    }


}
