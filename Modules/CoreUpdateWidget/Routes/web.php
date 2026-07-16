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

use Illuminate\Support\Facades\Route;

/**
 * User Routes
 */

Route::group([
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
    ),
    'namespace'  => 'Modules\CoreUpdateWidget\Http\Controllers',
], function () {
    // routes
}); // this should be the absolute last line of site route

/**
* Admin Routes
*/

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'Modules\CoreUpdateWidget\Http\Controllers\Admin',
], function () { // custom admin routes
    // routes
    Route::get('core/update', [\Modules\CoreUpdateWidget\Http\Controllers\UpdateController::class, 'update']);
}); // this should be the absolute last line of this file
