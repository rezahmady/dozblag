<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Article Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Article package.
|
*/

/**
 * User Routes
 */

use Rezahmady\Article\Http\Livewire\PostRender;

Route::group([
    'middleware'=> array_merge(
    	(array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::get('mag/{article:slug}/{subs?}', PostRender::class)
        ->where(['article' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*'])
        ->name('article');
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
    Route::crud('article', \Rezahmady\Article\Http\Controllers\Admin\ArticleCrudController::class);
    Route::crud('tag',  \Rezahmady\Article\Http\Controllers\Admin\TagCrudController::class);
});