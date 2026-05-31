<?php

namespace App\Filament\Resources\SiteSocials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SiteSocialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('social_id')
                    ->relationship('social', 'name')
                    ->label(__("Platform"))
                    ->required()
                    ->live(),

                TextInput::make('url')
                    ->label(__("Url"))
                    ->url()
                    ->required()
                    ->rules([
                        fn(Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                            $socialId = $get('social_id');
                            if (!$socialId) return;

                            $social = \App\Models\Social::find($socialId);
                            if (!$social) return;

                            if (!str_contains(strtolower($value), strtolower($social->name))) {
                                $fail(__("The URL must contain") . " ". $social->name . ".");
                            }
                        },
                    ]),
            ]);
    }
}
