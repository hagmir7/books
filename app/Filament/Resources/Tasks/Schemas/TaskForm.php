<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskPriorityEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->numeric()
                    ->default(1),
                Select::make('priority')
                    ->options(TaskPriorityEnum::class)
                    ->default(2)
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('due_date'),
                DateTimePicker::make('completed_at'),
                TextInput::make('type'),
                Textarea::make('tags')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
            ]);
    }
}
