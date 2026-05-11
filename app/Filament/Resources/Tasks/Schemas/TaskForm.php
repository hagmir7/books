<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Grid::make(3)
                    ->schema([

                        Section::make()
                            ->schema([

                                FileUpload::make('image')
                                    ->label(__("Image"))
                                    ->image(),
                                Select::make('status')
                                    ->label(__("Status"))
                                    ->options(TaskStatusEnum::toArray())
                                    ->native(false)
                                    ->required()
                                    ->default(1),
                                Select::make('priority')
                                    ->label(__("Priority"))
                                    ->options(TaskPriorityEnum::toArray())
                                    ->default(2)
                                    ->native(false)
                                    ->required(),


                                Select::make('type')
                                    ->options(
                                        [
                                            1 => __("Blog"),
                                            2 => __("Book")
                                        ]
                                    )
                                    ->native(false)
                                    ->label(__("Type")),
                            ])->columnSpan(1),
                        Section::make()
                            ->schema([

                                TextInput::make('title')
                                    ->label(__("Title"))
                                    ->columnSpanFull()
                                    ->required(),

                                DatePicker::make('due_date')
                                    ->label(__("Due date"))
                                    ->closeOnDateSelection()
                                    ->placeholder(now()->startOfMonth())
                                    ->native(false),
                                DateTimePicker::make('completed_at')
                                    ->label(__("Completed date"))
                                    ->closeOnDateSelection()
                                    ->native(false),
                                Textarea::make('description')
                                    ->label(__("Description"))
                                    ->columnSpanFull(),


                                TagsInput::make('tags')
                                    ->label(__('SEO Keywords'))
                                    ->placeholder(__('Add keywords'))
                                    ->separator(',')
                                    ->splitKeys([',', 'Enter', '،'])
                                    ->columnSpanFull(),
                            ])->columns(2)->columnSpan(2),
                    ])->columnSpanFull()
            ]);
    }
}
