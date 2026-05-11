<?php

namespace App\Filament\Widgets;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Actions\Action;

class TasksTable extends BaseWidget
{
    protected static ?string $heading = null;

    public function getTableHeading(): string
    {
        return __("Pending Tasks");
    }

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::where('site_id', app('site')->id)
                    ->where('user_id', auth()->id())
                    ->whereNot('status', TaskStatusEnum::COMPLETED)
                    ->orderBy('priority', 'desc')
            )
            ->columns([
                ImageColumn::make('image')
                    ->label(__("Image"))
                    ->circular(),

                TextColumn::make('title')
                    ->label(__("Title"))
                    ->wrap(),

                TextColumn::make('type')
                    ->label(__("Type"))
                    ->badge()
                    ->formatStateUsing(fn($state) => match ((int) $state) {
                        1 => __("Book"),
                        2 => __("Blog"),
                        default => __("Unknown"),
                    })
                    ->color(fn($state) => match ((int) $state) {
                        1 => 'info',
                        2 => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label(__("Status"))
                    ->badge()
                    ->formatStateUsing(fn(TaskStatusEnum $state) => $state->getLabel())
                    ->color(fn(TaskStatusEnum $state) => $state->getColor())
                    ->icon(fn(TaskStatusEnum $state) => $state->getIcon()),

                TextColumn::make('priority')
                    ->label(__("Priority"))
                    ->badge()
                    ->formatStateUsing(fn(TaskPriorityEnum $state) => $state->getLabel())
                    ->color(fn(TaskPriorityEnum $state) => $state->getColor())
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label(__("Due date"))
                    ->date()
                    ->sortable()
                    ->color(fn($state) => $state && \Carbon\Carbon::parse($state)->isPast() ? 'danger' : null),
            ])
            ->headerActions([
                Action::make('create')
                    ->label(__("New Task"))
                    ->icon('heroicon-m-plus')
                    ->color('primary')
                    ->url(fn() => route('filament.admin.resources.tasks.create')),

                Action::make('view_all')
                    ->label(__("View All"))
                    ->icon('heroicon-m-queue-list')
                    ->color('gray')
                    ->url(fn() => route('filament.admin.resources.tasks.index')),
            ])
            ->searchable(false)
            ->striped();
    }
}
