<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookCategoryResource\Pages;
use App\Filament\Resources\BookCategoryResource\RelationManagers;
use App\Models\BookCategory;
use Filament\Forms;
// use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class BookCategoryResource extends Resource
{
    protected static ?string $model = BookCategory::class;

    protected static string | UnitEnum | null $navigationGroup = 'More';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-swatch';


    public static function getModelLabel(): string
    {
        return __("Book category");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Book categories");
    }


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make()
                    ->schema([
                    \Filament\Forms\Components\FileUpload::make('image')
                        ->label(__("Image"))
                        ->image(),
                    ])
                    ->columnSpanFull(),


                \Filament\Forms\Components\TextInput::make('name')
                    ->unique()
                    ->label(__("Name"))
                    ->required()
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('title')
                    ->label(__("Title"))
                    ->unique()
                    ->maxLength(255),


                \Filament\Forms\Components\Textarea::make('description')
                    ->label(__("Description"))
                    ->columnSpanFull(),
            ]);
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('books_count')->counts('books')
                    ->label(__("Category"))
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBookCategories::route('/'),
            // 'create' => Pages\CreateBookCategory::route('/create'),
            // 'edit' => Pages\EditBookCategory::route('/{record}/edit'),
        ];
    }
}
