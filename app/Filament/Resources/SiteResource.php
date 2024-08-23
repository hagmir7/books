<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteResource\Pages;
use App\Filament\Resources\SiteResource\RelationManagers;
use App\Models\Site;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Site')
                            ->icon('heroicon-o-globe-alt')
                            // ->iconPosition(IconPosition::After)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('domain')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('language_id')
                                    ->relationship('language', 'name')
                                    ->native(false)
                                    ->required(),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass-circle')
                            // ->iconPosition(IconPosition::After)
                            ->schema([
                                Forms\Components\Textarea::make('keywords')
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull(),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->image(),

                                        Forms\Components\FileUpload::make('icon')
                                            ->image(),

                                        Forms\Components\FileUpload::make('logo')
                                            ->image(),
                                    ])
                            ]),
                        Forms\Components\Tabs\Tab::make('Advance')
                            ->icon('heroicon-o-cog-6-tooth')
                            // ->iconPosition(IconPosition::After)
                            ->schema([
                                Forms\Components\TextInput::make('ads_txt')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('header')
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('footer')
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make('Options')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\KeyValue::make('site_options')
                                    ->columnSpanFull(),
                            ])

                    ])
                    ->columnSpanFull()
                    ->activeTab(2),











                // FilamentJsonColumn::make('site_options')
                // ->columnSpanFull(),

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

                Tables\Columns\ImageColumn::make('icon'),
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
