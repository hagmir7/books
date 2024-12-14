<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailResource\Pages;
use App\Filament\Resources\EmailResource\RelationManagers;
use App\Models\Email;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmailResource extends Resource
{
    protected static ?string $model = Email::class;

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';
    protected static ?string $navigationGroup = 'Contact';

    public static function getModelLabel(): string
    {
        return __("Email");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Emails");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label(__("Email"))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('book_category_id')
                    ->label(__("Book Category"))
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label(__("Email"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('book_category_id')
                    ->label(__("Book category"))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__("Updated at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmails::route('/'),
            'create' => Pages\CreateEmail::route('/create'),
            'edit' => Pages\EditEmail::route('/{record}/edit'),
        ];
    }
}
