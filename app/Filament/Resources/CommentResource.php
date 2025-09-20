<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;



    protected static string | UnitEnum | null $navigationGroup = 'Contact';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function getModelLabel(): string
    {
        return __("Comment");
    }


    public static function getPluralLabel(): ?string
    {
        return __("Comments");
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('book_id')
                    ->label(__("Book"))
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->label(__("User"))
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('full_name')
                    ->label(__("Full name")),
                Forms\Components\TextInput::make('email')
                    ->label(__("Email"))
                    ->email(),
                Forms\Components\TextInput::make('stars')
                    ->label(__("Stars"))
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('body')
                    ->label(__("Content"))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('book.name')
                    ->label(__("Book"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__("Full name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__("Email"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('stars')
                    ->label(__("Stars"))
                    ->badge()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__("Deleted at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
