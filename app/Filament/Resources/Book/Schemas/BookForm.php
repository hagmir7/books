<?php

namespace App\Filament\Resources\Book\Schemas;

use App\Models\Author;
use App\Models\BookCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookForm
{
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Section::make()
                            ->schema([

                                TextInput::make('name')
                                    ->label(__("Book name"))
                                    ->unique(ignoreRecord: true)
                                    ->required(),

                                Select::make('author_id')
                                    ->relationship('author', 'full_name')
                                    ->label(__("Author"))
                                    ->searchable()
                                    ->preload()
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

                                Select::make('book_category_id')
                                    ->relationship('category', 'name')
                                    ->label(__("Category"))
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm(self::CategoryForm())
                                    ->createOptionModalHeading("Create category")
                                    ->createOptionUsing(function (array $data): int {
                                        $category = BookCategory::create($data);
                                        Notification::make()
                                            ->success()
                                            ->title(__("Category created successfully"))
                                            ->send();
                                        return $category->getKey();
                                    })
                                    ->native(false),

                                TextInput::make('isbn')
                                    ->label(__("ISBN")),

                                TextInput::make('pages')
                                    ->label(__("Pages")),

                                Toggle::make('verified')
                                    ->inline(false)
                                    ->label(__("Verified")),

                                TagsInput::make('tags')
                                    ->color('info')
                                    ->label(__("Keywords"))
                                    ->placeholder(__("New keyword"))
                                    ->separator(',')
                                    ->splitKeys([',', 'Enter', '،'])
                                    ->required()
                                    ->columnSpanFull()

                            ])
                            ->columns(2)
                            ->columnSpan(2),

                        Section::make()
                            ->schema([
                                Section::make()
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label(__("Image"))
                                            ->directory('book_images')
                                            ->image()
                                            ->visibility('public')
                                            ->preserveFilenames(),

                                        FileUpload::make('file')
                                            ->maxSize(5000000)
                                            ->label(__("File"))
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->directory('book_files')
                                            ->visibility('public')
                                            ->preserveFilenames()
                                            ->downloadable(),
                                    ])
                            ])
                            ->columnSpan(1)

                    ])
                    ->columnSpan(2),

                Textarea::make('description')
                    ->label(__("Description"))
                    ->rows(5)
                    ->columnSpanFull(),


                RichEditor::make('body')
                    ->label(__("Content"))
                    ->columnSpanFull(),


                Toggle::make('is_public')
                    ->label(__("Public"))
                    ->default(true)
                    ->required(),
            ]);
    }
}
