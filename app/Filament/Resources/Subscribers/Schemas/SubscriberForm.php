<?php

namespace App\Filament\Resources\Subscribers\Schemas;

use App\Enums\SubscriberStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                    ->label(__("Full name")),
                TextInput::make('email')
                    ->label(__('Email address'))
                    ->email()
                    ->required(),
                Select::make('status')
                    ->label(__("Status"))
                    ->required()
                    ->native(false)
                    ->options(SubscriberStatus::toArray())
                    ->default(1),
                Select::make('language_id')
                    ->label(__("Language"))
                    ->searchable()
                    ->preload()
                    ->relationship('language', 'name'),
                Select::make('site_id')
                    ->label(__("Website"))
                    ->searchable()
                    ->preload()
                    ->relationship('site', 'domain'),
            ]);
    }
}
