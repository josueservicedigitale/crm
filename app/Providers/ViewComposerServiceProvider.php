<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }
public function boot(): void
{
    View::composer('back.layouts.header', function ($view) {
        $user = Auth::user();

        if ($user) {
            // Conversations
            $conversations = $user->conversations()
                ->with(['users', 'lastMessage.user'])
                ->orderByDesc(
                    Conversation::select('created_at')
                        ->from('messages')
                        ->whereColumn('conversation_id', 'conversations.id')
                        ->latest()
                        ->limit(1)
                )
                ->limit(5)
                ->get();

            $unreadMessagesCount = $user->unreadMessagesCount();

            // Notifications
            $notifications = $user->unreadNotifications()->latest()->limit(5)->get();
            $unreadNotificationsCount = $user->unreadNotifications()->count();

            $view->with([
                'conversations' => $conversations,
                'unreadMessagesCount' => $unreadMessagesCount,
                'notifications' => $notifications,
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]);
        } else {
            // ✅ TOUJOURS retourner des valeurs par défaut !
            $view->with([
                'conversations' => collect(),
                'unreadMessagesCount' => 0,
                'notifications' => collect(),
                'unreadNotificationsCount' => 0,
            ]);
        }
    });
}
}