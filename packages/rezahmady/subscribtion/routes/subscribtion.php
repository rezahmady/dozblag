<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Subscribtion Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Subscribtion package.
|
*/

/**
 * User Routes
 */

use Rezahmady\Subscribtion\Http\Controllers\Admin\SubscribtionCrudController;
use Rezahmady\Subscribtion\Http\Livewire\Subscribtion;

Route::group([
    'middleware'=> array_merge(
    	(array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::middleware('auth')->get('subscribtion', Subscribtion::class)->name('subscribtion.view');
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
    Route::crud('subscribtion', SubscribtionCrudController::class);
});