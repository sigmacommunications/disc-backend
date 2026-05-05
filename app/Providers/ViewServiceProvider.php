<?php

namespace App\Providers;

use App\Models\SupportResponse;
use Auth;
use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layout.app', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                if ($user->hasRole('artist')) {
                    // Count unread responses for the artist's tickets
                    $unreadCount = SupportResponse::whereHas('supportTicket', function ($query) use ($user) {
                        $query->where('artist_id', $user->artist->id);
                    })->where('is_read', false)
                        ->where('user_id', '!=', $user->id)
                        ->count();
                } elseif ($user->hasRole('admin')) {
                    // Count all unread responses for admins
                    $unreadCount = SupportResponse::where('is_read', false)
                        ->where('user_id', '!=', $user->id)
                        ->count();
                } else {
                    $unreadCount = 0;
                }

                $view->with('unreadCount', $unreadCount);
            }
        });

    }
}
