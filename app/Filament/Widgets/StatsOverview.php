<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $todayBlogs = Post::whereDate('created_at', today())
            ->where('site_id', app('site')->id)
            ->count();

        $todayBooks = Book::whereDate('created_at', today())->count();

        $todayUsers = User::whereDate('created_at', today())->count();

        return [

            Stat::make(__('New users'), User::count())
                ->description($todayUsers . ' ' . __('Today users'))
                ->icon('heroicon-m-user-group'),

            Stat::make(__('Books'), Book::count())
                ->description($todayBooks . ' ' . __('Today books'))
                ->icon('heroicon-m-book-open'),

            Stat::make(__('Blogs'), Post::where('site_id', app('site')->id)->count())
                ->description($todayBlogs . ' ' . __('Today blogs'))
                ->icon('heroicon-m-bars-3-bottom-left'),
        ];
    }
}
