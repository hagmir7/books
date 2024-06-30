<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteResource\Pages;
use App\Filament\Resources\SiteResource\RelationManagers;
use App\Models\Site;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use ValentinMorice\FilamentJsonColumn\FilamentJsonColumn;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('domain')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('language_id')
                    ->relationship('language', 'name')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('ads_txt')
                    ->maxLength(255),

                Forms\Components\Textarea::make('keywords')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('header')
                    ->columnSpanFull(),

               Forms\Components\Textarea::make('footer')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->image(),
                Forms\Components\FileUpload::make('icon')
                    ->image(),
                Forms\Components\FileUpload::make('logo')
                    ->image(),

                // Forms\Components\Textarea::make('site_options')
                //     ->columnSpanFull()
                //     ->rows(5),

                FilamentJsonColumn::make('site_options')
                ->columnSpanFull(),

                Forms\Components\Repeater::make('urls')
                    ->relationship('urls')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__("Name"))
                            ->required(),
                        Forms\Components\TextInput::make('url')
                            ->label(__("Url"))
                            ->required(),
                        Forms\Components\Toggle::make('header')
                            ->label(__("Header"))
                            ->required(),
                        Forms\Components\Toggle::make('footer')
                            ->label(__("Fotter"))
                            ->required(),
                        Forms\Components\Toggle::make('new_tab')
                            ->label(__("New tab"))
                            ->required(),
                    ])->columns(2)
                    ->addActionLabel(__("Add url"))
                    ->default(1)
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('logo')
                    ->circular()
                    ->searchable(),
                Tables\Columns\TextColumn::make('domain')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('language.name')
                    ->sortable(),
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
            'index' => Pages\ListSites::route('/'),
            'create' => Pages\CreateSite::route('/create'),
            'edit' => Pages\EditSite::route('/{record}/edit'),
        ];
    }
}
