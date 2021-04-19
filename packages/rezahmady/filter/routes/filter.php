<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Filter Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Filter package.
|
*/

/**
 * User Routes
 */

use App\Http\Controllers\Api\FilterItemController;
use Rezahmady\Filter\Http\Controllers\Admin\FilterItemCrudController;
use Rezahmady\Filter\Http\Controllers\Admin\UserFilterItemCrudController;
use Rezahmady\Filter\Http\Controllers\Admin\FilterCrudController;
use Rezahmady\Filter\Http\Controllers\Admin\UserFilterCrudController;

Route::group([
    'middleware'=> array_merge(
    	(array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::post('api/filter-item',[FilterItemController::class, 'index'] );
    Route::post('api/filter-item/{id}', [FilterItemController::class, 'show']);
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
    Route::crud('resource/filter', UserFilterCrudController::class);
    Route::crud('resource/filteritem', UserFilterItemCrudController::class);
    Route::crud('filter', FilterCrudController::class);
    Route::crud('filteritem', FilterItemCrudController::class);
});