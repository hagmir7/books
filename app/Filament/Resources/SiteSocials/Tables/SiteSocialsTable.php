<?php

namespace App\Filament\Resources\SiteSocials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSocialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('social.name')
                    ->label(__("Platform"))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('url')
                    ->label(__("URL"))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__("Updated at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

            ])
            ->headerActions([
                CreateAction::make()
                    ->icon(Heroicon::OutlinedPlusCircle)
                    ->mutateDataUsing(function (array $data): array {
                        $data['site_id'] = app('site')->id;
                        return $data;
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
