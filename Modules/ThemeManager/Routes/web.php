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

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'Modules\ThemeManager\Http\Controllers\Admin',
], function () { // custom admin routes
    // Route::crud('category', 'CategoryCrudController');
    Route::crud('theme', 'ThemeCrudController');
    Route::get('theme/{theme_folder}/activate', 'ThemeCrudController@activate');
    Route::get('theme/{theme}/rebuild', 'ThemeCrudController@rebuild');
    Route::crud('widget', 'WidgetCrudController');
    Route::crud('menu', 'MenuCrudController');
}); // this should be the absolute last line of this file

