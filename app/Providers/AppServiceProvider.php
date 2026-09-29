<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('layouts.admin', function ($view) {
            $unreadMessages = \App\Models\Message::where('is_read', false)->latest()->take(5)->get();
            $unreadMessagesCount = \App\Models\Message::where('is_read', false)->count();

            $unapprovedComments = \App\Models\Comment::where('is_approved', false)->where('is_read', false)->latest()->take(5)->get();
            $unapprovedCommentsCount = \App\Models\Comment::where('is_approved', false)->where('is_read', false)->count();

            $totalNotifications = $unreadMessagesCount + $unapprovedCommentsCount;

            $view->with(compact('unreadMessages', 'unreadMessagesCount', 'unapprovedComments', 'unapprovedCommentsCount', 'totalNotifications'));
        });
    }
}
