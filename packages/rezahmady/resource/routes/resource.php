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
use Rezahmady\Resource\Http\Livewire\ResourceIndex;
use Rezahmady\Resource\Http\Livewire\ResourceList;
use Rezahmady\Resource\Http\Livewire\ResourceShow;

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