<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Chat Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Chat package.
|
*/

/**
 * User Routes
 */

use Rezahmady\Chat\Http\Controllers\Admin\ChatCrudController;
use Rezahmady\Chat\Http\Controllers\Admin\RoomCrudController;
use Rezahmady\Chat\Http\Livewire\Index;

Route::group([
    'middleware'=> array_merge(
    	['web', 'auth']
    ),
], function() {
    Route::get('doctorConsulation', Index::class)->name('chatyno.index');
    Route::middleware('room')->get('doctorConsulation/{id}', Index::class)->name('chatyno.show');
});


/**
 * Admin Routes
 */

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
], function () {
    Route::crud('room', RoomCrudController::class);
    Route::crud('chat', ChatCrudController::class);
    Route::get('reset-room/{room}', [RoomCrudController::class, 'resetRoom']);
    // Route::get('chats', Index::class)->name('chat.index');
});