<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TasksTable extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Task::where('site_id', app("site")->id)->where("user_id", auth()->id()))
            ->columns([
                // ...
            ]);
    }
}
