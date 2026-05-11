<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Enums\TaskStatusEnum;
use App\Filament\Resources\Tasks\TaskResource;
use Filament\Actions\CreateAction;
// use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__("New Task"))
                ->icon('heroicon-m-plus')
                ->modalHeading(__("Create New Task"))
                ->slideOver(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__("All"))
                ->icon('heroicon-m-queue-list')
                ->badge(fn() => $this->getModel()::where('site_id', app('site')->id)->where('user_id', auth()->id())->count()),

            'pending' => Tab::make(__("Pending"))
                ->icon(TaskStatusEnum::PENDING->getIcon())
                ->badgeColor(TaskStatusEnum::PENDING->getColor())
                ->badge(fn() => $this->getModel()::where('site_id', app('site')->id)->where('user_id', auth()->id())->where('status', TaskStatusEnum::PENDING)->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', TaskStatusEnum::PENDING)),

            'in_progress' => Tab::make(__("In Progress"))
                ->icon(TaskStatusEnum::IN_PROGRESS->getIcon())
                ->badgeColor(TaskStatusEnum::IN_PROGRESS->getColor())
                ->badge(fn() => $this->getModel()::where('site_id', app('site')->id)->where('user_id', auth()->id())->where('status', TaskStatusEnum::IN_PROGRESS)->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', TaskStatusEnum::IN_PROGRESS)),

            'completed' => Tab::make(__("Completed"))
                ->icon(TaskStatusEnum::COMPLETED->getIcon())
                ->badgeColor(TaskStatusEnum::COMPLETED->getColor())
                ->badge(fn() => $this->getModel()::where('site_id', app('site')->id)->where('user_id', auth()->id())->where('status', TaskStatusEnum::COMPLETED)->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', TaskStatusEnum::COMPLETED)),

            'canceled' => Tab::make(__("Canceled"))
                ->icon(TaskStatusEnum::CANCELED->getIcon())
                ->badgeColor(TaskStatusEnum::CANCELED->getColor())
                ->badge(fn() => $this->getModel()::where('site_id', app('site')->id)->where('user_id', auth()->id())->where('status', TaskStatusEnum::CANCELED)->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', TaskStatusEnum::CANCELED)),
        ];
    }
}
