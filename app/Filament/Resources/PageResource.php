<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use App\Models\Site;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';


    public static function getEloquentQuery(): Builder
    {
        $domain = str_replace('www.', '', request()->getHost());
        $site = Site::where('domain', $domain)->firstOrFail();
        return parent::getEloquentQuery()->where("site_id", $site->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__("Title"))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('site_id')
                    ->searchable()
                    ->preload()
                    ->relationship('site', 'name'),

                Forms\Components\Select::make('language_id')
                    ->searchable()
                    ->preload()
                    ->relationship('language', 'name'),

                Forms\Components\Toggle::make('markdown')
                    ->inline(false)
                    ->live()
                    ->label('Markdown'),

                Forms\Components\RichEditor::make('body')
                    ->label(__('Content'))
                    ->required()
                    ->hidden(fn (Get $get): bool => $get('markdown'))
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('body')
                    ->label(__('Content'))
                    ->required()
                    ->rows(10)
                    ->hidden(fn (Get $get): bool => !$get('markdown'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__("Title"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__("Created at")),
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
