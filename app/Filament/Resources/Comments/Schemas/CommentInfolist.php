<?php

namespace App\Filament\Resources\Comments\Schemas;


// use Dom\Comment;

use App\Models\Comment;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class CommentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('book.name')
                    ->url(fn(Comment $record): string => route('book.show', $record->book))
                    ->openUrlInNewTab()
                    ->size(TextSize::Medium)
                    ->label(__('Book name')),

                TextEntry::make('user.name')
                    ->size(TextSize::Medium)
                    ->label(__("User"))
                    ->placeholder('-'),
                TextEntry::make('full_name')
                     ->size(TextSize::Medium)
                    ->label(__("Full name"))
                    ->placeholder('-'),
                TextEntry::make('email')
                    ->label(__('Email address'))
                    ->url(fn (Comment $record): ?string =>
                        $record->email ? 'mailto:' . $record->email : null
                    )
                    ->size(TextSize::Medium)
                    ->placeholder('-'),
                TextEntry::make('stars')
                    ->badge()
                    ->color('yellow')
                    ->label(__("Stars"))
                    ->size(TextSize::Medium)
                    ->numeric(),

                TextEntry::make('created_at')
                    ->label(__("Created at"))
                    ->dateTime()
                    ->size(TextSize::Medium)
                    ->placeholder('-'),
                TextEntry::make('body')
                    ->label(__("Content"))
                    ->columnSpanFull(),


            ]);
    }
}
