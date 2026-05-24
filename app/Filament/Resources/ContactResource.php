<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Contact';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';

    public static function getModelLabel(): string
    {
        return __("Message");
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) parent::getEloquentQuery()
            ->whereNull('readed_at')
            ->count();
    }

    public static function getPluralLabel(): ?string
    {
        return __("Messages");
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('full_name')
                    ->label(__("Full name"))
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label(__("Email"))
                    ->email()
                    ->required(),
                Forms\Components\Textarea::make('body')
                    ->label(__("Content"))
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('readed_at')
                    ->label(__("Readed at"))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__("Full name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__("Email"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('readed_at')
                    ->label(__("Readed at"))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
