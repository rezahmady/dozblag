<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Resource Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Resource package.
|
*/

/**
 * User Routes
 */

use Rezahmady\Resource\Http\Controllers\Admin\ResourceCrudController;

// Route::group([
//     'middleware'=> array_merge(
//     	(array) config('backpack.base.web_middleware', 'web'),
//     ),
// ], function() {
//     Route::get('something/action', \Rezahmady\Resource\Http\Controllers\SomethingController::actionName());
// });


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
    Route::crud('resource', ResourceCrudController::class);
});