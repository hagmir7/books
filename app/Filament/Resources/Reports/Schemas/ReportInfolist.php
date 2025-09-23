<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('full_name')
                    ->label(__("Full name")),
                TextEntry::make('subject')
                    ->label(__("Subject")),
                TextEntry::make('email')
                    ->label(__('Email address')),
                TextEntry::make('readed_at')
                    ->label(__("Readed at"))
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('book.name')
                    ->label(__("Book name"))
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label(__("Created at"))
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('content')
                    ->label(__("Content"))
                    ->columnSpanFull(),
            ]);
    }
}
