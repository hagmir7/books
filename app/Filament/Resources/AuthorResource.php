<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;


    protected static string | UnitEnum | null $navigationGroup = 'More';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-circle';


    public static function getModelLabel(): string
    {
        return __("Author");
    }


    public static function getPluralLabel(): ?string
    {
        return __("Authors");
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(3)
                    ->schema([


                        Section::make()
                            ->schema([
                                TextInput::make('full_name')
                                    ->label(__("Full name"))
                                    ->unique()
                                    ->required(),
                                RichEditor::make('description')
                                    ->label(__("Description"))
                                    ->extraInputAttributes(['style' => 'min-height: 20rem; max-height: 50vh; overflow-y: auto;'])
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(2),



                        Section::make()
                            ->schema([

                                FileUpload::make('image')
                                    ->label(__("Image"))
                                    ->avatar()
                                    // ->label(false)
                                    ->alignment(Alignment::Center)
                                    ->columnSpanFull()

                                    ->required(),

                                Toggle::make('verified')
                                    ->inline(false)
                                    ->label(__("Verified")),


                            ])
                            ->columnSpan(1)



                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__("Image")),

                Tables\Columns\TextColumn::make('full_name')
                    ->label(__("Full name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('books_count')->counts('books')
                    ->label(__("Books"))
                    ->badge()
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
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         BooksRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
