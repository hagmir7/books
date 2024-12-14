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
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Termwind\Enums\Color;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getModelLabel(): string
    {
        return __("Book");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Books");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([

                            Forms\Components\TextInput::make('name')
                                ->label("Name")
                                ->unique(ignoreRecord: true)
                                ->required(),

                            Forms\Components\Select::make('author_id')
                                ->relationship('author', 'full_name')
                                ->label("Author")
                                ->native(false)
                                ->createOptionForm(self::AuthorForm())
                                ->createOptionModalHeading("Create new author")
                                ->createOptionUsing(function (array $data): int {
                                    $author = Author::create($data);
                                    Notification::make()
                                    ->success()
                                    ->title("Author created successfully")
                                    ->send();
                                    return $author->getKey();
                                }),

                            Forms\Components\Select::make('book_category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm(self::CategoryForm())
                                ->createOptionModalHeading("Create category")
                                ->createOptionUsing(function (array $data): int {
                                    $category = BookCategory::create($data);
                                    Notification::make()
                                    ->success()
                                    ->title("Category created successfully")
                                    ->send();
                                    return $category->getKey();
                                })
                                    ->native(false),

                            Forms\Components\Select::make('language_id')
                                ->native(false)
                                ->relationship('language', 'name'),

                            Forms\Components\TagsInput::make('tags')
                                ->color('info')
                                ->label(__("Keywords"))
                                ->placeholder(__("New keyword"))
                                ->separator(',')
                                ->splitKeys(['Tab', ','])
                                ->required()
                                ->columnSpanFull()

                        ])
                        ->columns(2)
                        ->columnSpan(2),

                    Forms\Components\Section::make()
                        ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->directory('book_images')
                                    ->image(),

                                Forms\Components\FileUpload::make('file')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->directory('book_files'),
                            ])
                        ->columnSpan(1)

                ])
                ->columnSpan(2),

                Forms\Components\Textarea::make('description')
                    ->rows(5)
                    ->columnSpanFull(),


                Forms\Components\RichEditor::make('body')
                    ->columnSpanFull(),


                Forms\Components\Toggle::make('is_public')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('author.full_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pages')
                    ->placeholder("__")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->badge()
                    ->color('success')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_public')
                    ->boolean(),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
                        ->avatar()
                        ->label(false)
                        ->alignment(Alignment::Center)
                        ->columnSpanFull()
                        ->directory('author_images'),
                    Forms\Components\TextInput::make('full_name')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('description')
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
                        ->required(),
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->directory('category_images'),
                    Forms\Components\RichEditor::make('description')
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
