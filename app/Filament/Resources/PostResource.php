<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\Site;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-4';


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where("site_id", app('site')->id);
    }

    public static function getPluralLabel(): ?string
    {
        return __("Blogs");
    }


    public static function getModelLabel(): string
    {
        return __("Blog");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label(__("Title"))
                                    ->required(),

                                Forms\Components\TagsInput::make('tags')
                                    ->color('info')
                                    ->label(__("Keywords"))
                                    ->placeholder(__("New keyword"))
                                    ->separator(',')
                                    ->splitKeys([',', 'Enter', '،'])
                                    ->required()
                                    ->reorderable()
                                    ->nestedRecursiveRules([
                                        'min:3',
                                        'max:100',
                                    ])
                                ])
                                ->columnSpan(2),

                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('language_id')
                                    ->native(false)
                                    ->label(__("Language"))
                                    ->relationship('language', "name")
                                    ->required(),
                                Forms\Components\FileUpload::make('image')
                                    ->label(__("Image"))
                                    ->maxSize(100048576)
                                    ->columnSpanFull()
                                    ->acceptedFileTypes(['image/*'])
                                    ->downloadable()
                                    ->image(),
                            ])
                            ->columnSpan(1)

                    ])->columnSpan(2),

                Forms\Components\Section::make()
                    ->schema([

                        Forms\Components\Textarea::make('description')
                            ->label(__("Description"))
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('markdown')
                            ->label(__("Markdown"))
                            ->live(),

                        Forms\Components\RichEditor::make('body')
                            ->label(__('Content'))
                            ->required()
                            ->hidden(fn (Get $get): bool => $get('markdown'))
                            ->columnSpanFull(),

                        Forms\Components\MarkdownEditor::make('body')
                            ->label(__('Content'))
                            ->required()
                            ->hidden(fn (Get $get): bool => !$get('markdown'))
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'heading',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'table',
                                'undo',
                            ]),

                    ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__("Image")),
                Tables\Columns\TextColumn::make('title')
                    ->label(__("Title"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('language.name')
                    ->label(__("Language"))
                    ->badge()
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
