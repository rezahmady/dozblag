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

use Modules\Resource\Http\Controllers\Admin\ResourceCrudController;
use Modules\Resource\Http\Livewire\ResourceIndex;
use Modules\Resource\Http\Livewire\ResourceList;
use Modules\Resource\Http\Livewire\ResourceShow;

Route::group([
    'middleware'=> array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::group(['prefix'=>'/resource','as'=>'resource.'], function() {
        Route::get('/', ResourceIndex::class)->name('all');
        Route::get('/{resource:template}', ResourceList::class)->name('list');
        Route::get('/show/{resource:slug}', ResourceShow::class)->name('show');
    });
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
    Route::crud('resource', ResourceCrudController::class);
});
