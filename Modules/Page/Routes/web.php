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

use App\Http\Livewire\Home;
use Modules\Page\Http\Controllers\Admin\PageCrudController;
use Modules\Page\Http\Controllers\FormController;

Route::group([
    'middleware'=> array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {

    Route::get('/', Home::class)->name('home');

    Route::post('/form/{page:id}', [FormController::class, 'save'])->name('form.save');

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
    Route::crud('page', PageCrudController::class);
});

Route::get('{modelPage}/{subs?}', \Modules\Page\Http\Livewire\PageRender::class)
    ->where(['modelPage' => '^(((?=(?!admin)(?!doctor)(?!auth)(?!profile))(?=(?!\/)).))*$', 'subs' => '.*'])
    ->name('page');
