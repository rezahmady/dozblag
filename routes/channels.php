<?php

use Illuminate\Support\Facades\Broadcast;

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


Broadcast::channel('consultation.added', function ($user) {
    // return (int) $user->id === (int) $id;
    return auth()->user();
});

Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    // return (int) $user->id === (int) $id;
    return auth()->user();
});

Broadcast::channel('chat.{roomId}.user.{sender}', function ($user, $roomId, $sender) {
    // return (int) $user->id === (int) $sender;
    return auth()->user();
});

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
