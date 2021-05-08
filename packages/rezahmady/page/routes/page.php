<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Page Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Page package.
|
*/

/**
 * User Routes
 */

use App\Http\Livewire\Home;
use Rezahmady\Page\Http\Controllers\Admin\PageCrudController;
use Rezahmady\Page\Http\Controllers\FormController;

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