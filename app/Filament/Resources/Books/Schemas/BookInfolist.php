<?php

namespace App\Filament\Resources\Books\Schemas;

use App\Models\Book;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('title')
                    ->placeholder('-'),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('author.id')
                    ->label('Author')
                    ->placeholder('-'),
                TextEntry::make('book_category_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('language_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('pages')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('size')
                    ->placeholder('-'),
                TextEntry::make('type')
                    ->placeholder('-'),
                ImageEntry::make('image')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('body')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('tags')
                    ->placeholder('-'),
                TextEntry::make('file')
                    ->placeholder('-'),
                IconEntry::make('is_public')
                    ->boolean(),
                TextEntry::make('slug')
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Book $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('site_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('isbn')
                    ->placeholder('-'),
                TextEntry::make('copyright_date')
                    ->date()
                    ->placeholder('-'),
                IconEntry::make('verified')
                    ->boolean(),
            ]);
    }
}
