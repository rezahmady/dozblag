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
    return true;
});

Broadcast::channel('chat', function ($user) {
    return Arr::only($user->toArray(), [
        'id', 'name'
    ]);
});

Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    return Arr::only($user->toArray(), [
        'id', 'name'
    ]);
});

Broadcast::channel('chat.{roomId}.user.{sender}', function ($user, $roomId, $sender) {
    return Arr::only($user->toArray(), [
        'id', 'name'
    ]);
});