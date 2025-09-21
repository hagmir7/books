<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteResource\Pages;
use App\Filament\Resources\SiteResource\RelationManagers;
use App\Models\Site;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;


    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-globe-asia-australia';

    public static function getModelLabel(): string
    {
        return __("Website");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Websites");
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Site')
                            ->label(__("Websites"))
                            ->icon('heroicon-o-globe-alt')
                            // ->iconPosition(IconPosition::After)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__("Site name"))
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('domain')
                                    ->label(__("Domain"))
                                    ->suffixIcon('heroicon-m-globe-alt')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('language_id')
                                    ->relationship('language', 'name')
                                    ->suffixIcon('heroicon-m-language')
                                    ->label(__("Language"))
                                    ->native(false)
                                    ->required(),

                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->suffixIcon('heroicon-m-at-symbol')
                                    ->label(__("Email"))
                            ])->columns(3),
                        Tab::make('SEO')
                            ->label(__("SEO"))
                            ->icon('heroicon-o-magnifying-glass-circle')
                            // ->iconPosition(IconPosition::After)
                            ->schema([
                                Forms\Components\Textarea::make('description')
                                    ->label(__("Description"))
                                    ->rows(5)
                                    ->columnSpanFull(),
                                Forms\Components\TagsInput::make('keywords')
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
                                    ]),



                                \Filament\Schemas\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->label(__("Image"))
                                            ->image(),

                                        Forms\Components\FileUpload::make('icon')
                                            ->label(__("Icon"))
                                            ->image(),

                                        Forms\Components\FileUpload::make('logo')
                                            ->label(__("Logo"))
                                            ->image(),
                                    ])
                            ]),
                        Tab::make('Advance')
                            ->label(__("Advance"))
                            ->icon('heroicon-o-chart-bar')
                            // ->iconPosition(IconPosition::After)
                            ->schema([
                                Forms\Components\Textarea::make('header')
                                    ->label(__("Header"))
                                    ->rows(5)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('footer')
                                    ->rows(5)
                                    ->label(__("Footer"))
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('ads_txt')
                                    ->label(__("Ads TXT"))
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('ads')
                                    ->label(__("Ads"))
                                    ->columnSpanFull(),


                            ]),

                        Tab::make('Options')
                            ->label(__("Options"))
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\KeyValue::make('site_options')
                                    ->label(__("Site options"))
                                    ->columnSpanFull(),
                            ])

                    ])
                    ->columnSpanFull()
                    ->activeTab(2),

                // FilamentJsonColumn::make('site_options')
                // ->columnSpanFull(),

                Forms\Components\Repeater::make('urls')
                    ->label(__("Urls"))
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

                Tables\Columns\ImageColumn::make('icon')
                    ->label(__("Logo")),
                Tables\Columns\TextColumn::make('domain')
                    ->label(__("Domain name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__("Email"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('language.name')
                    ->label(__("Language"))
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
            ->recordActions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
                \Filament\Actions\ReplicateAction::make(),



            ])
            ->toolbarActions([
                \Filament\Actions\DeleteBulkAction::make(),
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
