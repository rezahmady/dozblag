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

use Modules\DevTools\Http\Controllers\DevToolsController;

Route::prefix('/admin/devtools')->group(function() {
    Route::get('/', [ DevToolsController::class, 'index']);
});

