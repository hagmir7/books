<?php

namespace App\Filament\Resources;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getModelLabel(): string
    {
        return __("Task");
    }
    public static function getPluralLabel(): ?string
    {
        return __("Tasks");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__("Title"))
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('due_date')
                    ->native(false)
                    ->placeholder(__("Due date"))
                    ->label(__("Due date")),
                Forms\Components\Textarea::make('description')
                    ->label(__("Description"))
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label(__("Status"))
                    ->options(TaskStatusEnum::toArray())
                    ->native(false)
                    ->required()
                    ->default(1),
                Forms\Components\Select::make('priority')
                    ->label(__("Priority"))
                    ->options(TaskPriorityEnum::toArray())
                    ->default(2)
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'id')
                    ->native(false)
                    ->label(__("Assigned User"))
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->first_name . ' ' . $record->last_name),

                Forms\Components\DateTimePicker::make('completed_at')
                    ->placeholder(__("Completed date"))
                    ->native(false)
                    ->label(__("Completed date")),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                // Tables\Columns\TextColumn::make('site.domain')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('priority', fn($record) => $record->priority?->getLabel() ?? 'N/A')
                    ->badge(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options(TaskStatusEnum::toArray())
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
                Tables\Actions\EditAction::make()
                    ->label(false)
                    ->tooltip(__("Edit"))
                    ->iconSize(IconSize::Medium),
                Tables\Actions\DeleteAction::make()
                    ->label(false)
                    ->tooltip(__("Delete"))
                    ->iconSize(IconSize::Medium)
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

        ];
    }




    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                 TextEntry::make('title')
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            // 'create' => Pages\CreateTask::route('/create'),
            // 'edit' => Pages\EditTask::route('/{record}/edit'),

            'view' => Pages\ViewTask::route('/{record}/view'),
        ];
    }
}
