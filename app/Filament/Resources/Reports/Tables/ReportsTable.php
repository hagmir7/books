<?php

namespace App\Filament\Resources\Reports\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.name')
                    ->label(__("Book name"))
                    ->sortable(),
                TextColumn::make('full_name')
                    ->label(__("Full name"))
                    ->searchable(),
                TextColumn::make('subject')
                    ->label(__("Subject"))
                    ->searchable(),
                TextColumn::make('readed_at')
                    ->label(__("Readed at"))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('mark_as_read')
                        ->label(__("Mark as read"))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(
                                fn($record) => $record->update(['readed_at' => now()])
                            );
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
