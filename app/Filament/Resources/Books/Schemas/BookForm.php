<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Support\Icons\Heroicon;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // Main Info Section
            Grid::make()
                ->schema([

                    Section::make()
                        ->schema([

                            TextInput::make('name')
                                ->label(__("Book name"))
                                ->required()
                                ->columnSpan(2),


                            Select::make('author_id')
                                ->relationship('author', 'full_name')
                                ->searchable()
                                ->preload()
                                ->label(__("Author")),

                            Select::make('book_category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->label(__("Category")),

                            TextInput::make('isbn')
                                ->label(__("ISBN")),

                            TextInput::make('pages')
                                ->label(__('Pages'))
                                ->numeric(),

                            TagsInput::make('tags')
                                ->label(__('SEO Keywords'))
                                ->placeholder(__('Add keywords'))
                                ->separator(',')
                                ->splitKeys([',', 'Enter', '،'])
                                ->columnSpan([
                                    'default' => 1,
                                    'md' => 2,
                                ]),

                        ])->columnSpan(2)
                        ->columns(2),


                    Section::make()
                        ->schema([

                            FileUpload::make('image')
                                ->label(__("Image"))
                                ->directory('book_images')
                                ->columnSpanFull()
                                ->image(),
                            FileUpload::make('file')
                                ->maxSize(5000000)
                                ->acceptedFileTypes(['application/pdf'])
                                ->directory('book_files')
                                ->columnSpanFull()
                                ->label(__("File")),

                            Toggle::make('is_public')
                                ->label(__("Is public"))
                                ->inline(false)
                                ->required(),

                            Toggle::make('verified')
                                ->label(__("Verified"))
                                ->inline(false)
                                ->required(),
                        ])
                        ->columns(2)
                        ->columnSpan(1),

                ])->columns(3)
                ->columnSpanFull(),


            Textarea::make('description')
                ->label(__("Description"))
                ->columnSpanFull(),
            RichEditor::make('body')
                ->label(__("Content"))
                ->extraInputAttributes(['style' => 'min-height: 20rem; max-height: 50vh; overflow-y: auto;'])
                ->columnSpanFull(),


            Section::make(__("Advanced info"))
                ->collapsed()
                ->icon(Heroicon::OutlinedInformationCircle)
                ->schema([
                    Grid::make()
                        ->columns(2)
                        ->schema([

                            TextInput::make('title')
                                ->label(__("Title")),
                            TextInput::make('size')
                                ->label(__("Size")),

                            TextInput::make('type')
                                ->label(__("Type")),

                            DatePicker::make('copyright_date')
                                ->native(false)
                                ->label(__("Copyright")),

                            Select::make('site_id')
                                ->relationship('site', 'name')
                                ->label(__("Website")),

                            TextInput::make('slug')
                                ->label(__("Slug")),


                            Select::make('language_id')
                                ->relationship('language', 'name')
                                ->searchable()
                                ->preload()
                                ->label(__("Language")),





                        ])
                ])
                ->columnSpanFull(),
        ])
            ->columns(3);
    }
}
