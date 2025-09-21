<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Termwind\Enums\Color;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;



    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    public static function getModelLabel(): string
    {
        return __("Book");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Books");
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('language_id', app('site')->language->id);
    }

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__("Image")),

                Tables\Columns\TextColumn::make('name')
                    ->label(__("Name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('author.full_name')
                    ->searchable()
                    ->label(__("Author"))
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__("Category"))
                    ->searchable()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language.name')
                    ->label(__("Language"))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pages')
                    ->label(__("Pages"))
                    ->placeholder("__")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->label(__("Size"))
                    ->badge()
                    ->color('success')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__("Type"))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label(__("Is public"))
                    ->boolean(),


                Tables\Columns\TextColumn::make('created_at')
                    ->label(__("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__("Update at"))
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

    public static function AuthorForm(): array
    {
        return [
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label(__("Image"))
                        ->avatar()
                        ->label(false)
                        ->alignment(Alignment::Center)
                        ->columnSpanFull()
                        ->directory('author_images'),
                    Forms\Components\TextInput::make('full_name')
                        ->label(__("Full name"))
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('description')
                        ->label(__("Description"))
                        ->columnSpanFull(),
                ])->columns(2)
        ];
    }

    public static function CategoryForm(): array
    {
        return [
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__("Name"))
                        ->required(),
                    Forms\Components\FileUpload::make('image')
                        ->label(__("Image"))
                        ->image()
                        ->directory('category_images'),
                    Forms\Components\RichEditor::make('description')
                        ->label(__("Description"))
                        ->columnSpanFull(),
                ])
        ];
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
