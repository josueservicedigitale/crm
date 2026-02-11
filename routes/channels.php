<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Canal privé pour une conversation
Broadcast::channel('conversation.{id}', function ($user, $id) {
    // L'utilisateur peut écouter s'il est participant
    return $user->conversations()->where('conversation_id', $id)->exists();
});

// Canal de présence pour les utilisateurs en ligne
Broadcast::channel('presence-online', function ($user) {
    return $user ? [
        'id' => $user->id,
        'name' => $user->name,
        'avatar' => $user->avatar,
    ] : null;
});