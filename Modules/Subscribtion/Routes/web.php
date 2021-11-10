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

use Modules\Subscribtion\Http\Controllers\Admin\SubscribtionCrudController;
use Modules\Subscribtion\Http\Controllers\Api\SubscribtionController;
use Modules\Subscribtion\Http\Livewire\Subscribtion;

Route::group([
    'middleware'=> array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::middleware('auth')->get('subscribtion', Subscribtion::class)->name('subscribtion.view');

    Route::group(['prefix'=>'api'], function(){
        Route::get('/subscribtion', [SubscribtionController::class, 'subscribtion']);
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
    Route::crud('subscribtion', SubscribtionCrudController::class);
});
