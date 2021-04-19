<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Product Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Product package.
|
*/

/**
 * User Routes
 */

use Rezahmady\Product\Http\Controllers\Admin\ProductCrudController;
use Rezahmady\Product\Http\Livewire\Show;

Route::group([
    'middleware'=> array_merge(
    	(array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::get('/product/{product:slug}', Show::class)->name('product.show');
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
    Route::crud('product', ProductCrudController::class);
});