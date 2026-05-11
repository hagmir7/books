<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Post;
use App\Services\ChatGPTService;

use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label(__("Image"))
                    ->circular(),

                TextColumn::make('title')
                    ->label(__("Title"))
                    ->searchable()
                    ->sortable()
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
                    })
                    ->searchable(),

                TextColumn::make('status')
                    ->label(__("Status"))
                    ->badge()
                    ->formatStateUsing(fn(TaskStatusEnum $state) => $state->getLabel())
                    ->color(fn(TaskStatusEnum $state) => $state->getColor())
                    ->icon(fn(TaskStatusEnum $state) => $state->getIcon())
                    ->sortable(),

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

                TextColumn::make('completed_at')
                    ->label(__("Completed date"))
                    ->dateTime()
                    ->sortable()
                    ->placeholder(__("Not completed")),

                TextColumn::make('created_at')
                    ->label(__("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__("Updated at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

                Action::make('generate_blog')
                    ->label(__("Generate Blog"))
                    ->icon('heroicon-m-sparkles')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading(__("Generate Blog from Task"))
                    ->modalDescription(__("This will use AI to generate a full blog post from this task's data. This may take a moment."))
                    ->modalSubmitActionLabel(__("Generate"))
                    ->action(function ($record) {
                        $data = app(ChatGPTService::class)->generateBlogFromTask($record);

                        if (empty($data)) {
                            Notification::make()
                                ->title(__("Generation Failed"))
                                ->body(__("AI failed to generate the blog. Please try again."))
                                ->danger()
                                ->send();
                            return;
                        }

                        $site = app('site');

                        Post::create([
                            'title'       => $data['title'],
                            'image'       => $record->image,
                            'tags'        => $data['tags'],
                            'description' => $data['meta_description'],
                            'body'        => $data['body'],
                            'user_id'     => Auth::id(),
                            'language_id' => $site->language_id,
                            'site_id'     => $site->id,
                        ]);

                        Notification::make()
                            ->title(__("Blog Generated Successfully"))
                            ->body(__("The blog post has been created from this task."))
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
