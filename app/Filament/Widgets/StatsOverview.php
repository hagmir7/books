<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
// use Spatie\FilamentSimpleStats\SimpleStat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $todyaBlogs = Post::where('created_at', now());
        $todyaBooks = Book::where('created_at', now());
        $todyaUsers = Book::where('created_at', now());
        return [

            Stat::make(__("New users"), User::count())
                ->description($todyaUsers->count(). " " . __("Today users"))
                ->icon('heroicon-m-user-group'),

            Stat::make(__("Books"), Book::count())
                ->description($todyaBooks->count(). " " . __("Today books"))
                ->icon('heroicon-m-book-open'),

            Stat::make(__("Blogs"), Post::where('site_id', app('site')->id)->count())
                ->description($todyaBlogs->count(). " " . __("Today blogs"))
                ->icon('heroicon-m-bars-3-bottom-left')
        ];
    }
}
