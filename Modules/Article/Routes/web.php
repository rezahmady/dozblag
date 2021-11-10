<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * User Routes
 */

use Modules\Article\Http\Livewire\PostRender;
use Modules\Article\Http\Livewire\TagRender;

Route::group([
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
    ),
], function () {
    Route::get('mag/{article:slug}/{subs?}', PostRender::class)
        ->where(['article' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*'])
        ->name('article');

    Route::get('tag/{tag:slug}', TagRender::class)
        ->name('tag.site.show');
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
    Route::crud('article', \Modules\Article\Http\Controllers\Admin\ArticleCrudController::class);
    Route::crud('tag',  \Modules\Article\Http\Controllers\Admin\TagCrudController::class);
});
