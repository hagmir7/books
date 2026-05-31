<?php

namespace App\Filament\Resources\SiteSocials;

use App\Filament\Resources\SiteSocials\Pages\CreateSiteSocial;
use App\Filament\Resources\SiteSocials\Pages\EditSiteSocial;
use App\Filament\Resources\SiteSocials\Pages\ListSiteSocials;
use App\Filament\Resources\SiteSocials\Schemas\SiteSocialForm;
use App\Filament\Resources\SiteSocials\Tables\SiteSocialsTable;
use App\Models\SiteSocial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Override;
use UnitEnum;

class SiteSocialResource extends Resource
{
    protected static ?string $model = SiteSocial::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;


    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-paper-clip';

    public static function getLabel(): string
    {
        return __("Social Media");
    }


    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __("More");
    }

    public static function getPluralLabel(): string
    {
        return __("Social Media");
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('site_id', app("site")->id)
            ->latest();
    }



    protected static ?string $recordTitleAttribute = 'url';

    public static function form(Schema $schema): Schema
    {
        return SiteSocialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiteSocialsTable::configure($table);
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
            'index' => ListSiteSocials::route('/'),
            // 'create' => CreateSiteSocial::route('/create'),
            // 'edit' => EditSiteSocial::route('/{record}/edit'),
        ];
    }
}
