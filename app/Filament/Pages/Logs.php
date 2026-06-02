<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Override;
use UnitEnum;

class Logs extends Page
{
    protected string $view = 'filament.pages.logs';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedDocumentText;


    public function getTitle(): string|Htmlable
    {
        return '';
    }

    protected static string | UnitEnum | null $navigationGroup = 'More';


    public static function getNavigationLabel(): string
    {
        return __("Logs");
    }

}
