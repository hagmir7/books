<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-flag';

    public static function getModelLabel(): string
    {
        return __('Report');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Reports');
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->whereNotNull('readed_at')->latest();
    // }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make(__('Contact Information'))
                            ->schema([
                                Forms\Components\TextInput::make('full_name')
                                    ->label(__('Full name'))
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('email')
                                    ->label(__('Email'))
                                    ->email()
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('subject')
                                    ->label(__('Subject'))
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make(__('Report Details'))
                            ->schema([
                                Forms\Components\Select::make('book_id')
                                    ->label(__('Related Book'))
                                    ->relationship('book', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder(__('Select a book (optional)')),

                                Forms\Components\DateTimePicker::make('readed_at')
                                    ->label(__('Readed at'))
                                    ->placeholder(__('Mark as read')),
                            ]),
                    ]),

                Forms\Components\Textarea::make('content')
                    ->label(__('Report Content'))
                    ->required()
                    ->rows(6)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('Full name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->copyable()
                    ->copyMessage(__('Email copied'))
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('book.name')
                    ->label(__('Related Book'))
                    ->badge()
                    ->color('info')
                    ->placeholder('__'),

                Tables\Columns\IconColumn::make('readed_at')
                    ->label(__('Status'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->sortable(),

                Tables\Columns\TextColumn::make('readed_at')
                    ->label(__('Readed at'))
                    ->placeholder('__')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('readed_at')
                    ->label(__('Status'))
                    ->placeholder(__('All reports'))
                    ->trueLabel(__('Read reports'))
                    ->falseLabel(__('Unread reports'))
                    ->queries(
                        true: fn(Builder $query) => $query->whereNotNull('readed_at'),
                        false: fn(Builder $query) => $query->whereNull('readed_at'),
                    ),

                Tables\Filters\SelectFilter::make('book_id')
                    ->label(__('Related Book'))
                    ->relationship('book', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label(__('Created from')),
                        Forms\Components\DatePicker::make('created_until')
                            ->label(__('Created until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),


                \Filament\Actions\Action::make('mark_as_read')
                    ->label(__('Mark as read'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Report $record) {
                        $record->update(['readed_at' => now()]);
                    })
                    ->visible(fn(Report $record) => $record->readed_at === null)
                    ->requiresConfirmation()
                    ->modalHeading(__('Mark report as read'))
                    ->modalDescription(__('Are you sure you want to mark this report as read?'))
                    ->modalSubmitActionLabel(__('Yes, mark as read')),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    \Filament\Actions\BulkAction::make('mark_as_read')
                        ->label(__('Mark as read'))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['readed_at' => now()]);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading(__('Mark reports as read'))
                        ->modalDescription(__('Are you sure you want to mark the selected reports as read?'))
                        ->modalSubmitActionLabel(__('Yes, mark as read')),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public function ReportInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->report)
            ->components([
                Infolists\Components\Grid::make(3)
                    ->schema([
                        Infolists\Components\Section::make(__('Contact Information'))
                            ->schema([
                                Infolists\Components\TextEntry::make('full_name')
                                    ->label(__('Full name'))
                                    ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('email')
                                    ->label(__('Email'))
                                    ->copyable()
                                    ->copyMessage(__('Email copied'))
                                    ->icon('heroicon-m-envelope')
                                    ->url(fn($record) => 'mailto:' . $record->email)
                                    ->color('primary'),

                                Infolists\Components\TextEntry::make('subject')
                                    ->label(__('Subject'))
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(2),

                        Infolists\Components\Section::make(__('Report Details'))
                            ->schema([
                                Infolists\Components\TextEntry::make('book.name')
                                    ->label(__('Related Book'))
                                    ->badge()
                                    ->color('info')
                                    ->placeholder('__'),

                                Infolists\Components\IconEntry::make('readed_at')
                                    ->label(__('Status'))
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-clock')
                                    ->trueColor('success')
                                    ->falseColor('warning'),

                                Infolists\Components\TextEntry::make('readed_at')
                                    ->label(__('Readed at'))
                                    ->placeholder('__')
                                    ->dateTime(),

                                Infolists\Components\TextEntry::make('created_at')
                                    ->label(__('Created at'))
                                    ->dateTime(),

                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label(__('Updated at'))
                                    ->dateTime(),
                            ])
                            ->columnSpan(1),
                    ]),

                Infolists\Components\Section::make(__('Report Content'))
                    ->schema([
                        Infolists\Components\TextEntry::make('content')
                            ->label(__('Content'))
                            ->prose()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            // 'view' => Pages\ViewReport::route('/{record}'),
            // 'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
