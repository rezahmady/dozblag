<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Profile Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Profile package.
|
*/

/**
 * User Routes
 */

use Rezahmady\Profile\Http\Controllers\Livewire\Dashboard;
use Rezahmady\Profile\Http\Controllers\Livewire\Info;
use Rezahmady\Profile\Http\Controllers\Livewire\Medical;

Route::group([
    'middleware'=> array_merge(
    	['web', 'auth']
    ),
    'prefix' => 'profile',
    'as' => 'profile.',
], function() {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/info', Info::class)->name('info');
    Route::get('/medical_folder', Medical::class)->name('medical');
});


/**
 * Admin Routes
 */

// Route::group([
//     'prefix' => config('backpack.base.route_prefix', 'admin'),
//     'middleware' => array_merge(
//         (array) config('backpack.base.web_middleware', 'web'),
//         (array) config('backpack.base.middleware_key', 'admin')
//     ),
// ], function () {
//     Route::crud('some-entity-name', \Rezahmady\Profile\Http\Controllers\Admin\EntityNameCrudController::class);
// });