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

use Modules\Filter\Http\Controllers\Api\FilterItemController;
use Modules\Filter\Http\Controllers\Admin\FilterItemCrudController;
use Modules\Filter\Http\Controllers\Admin\UserFilterItemCrudController;
use Modules\Filter\Http\Controllers\Admin\FilterCrudController;
use Modules\Filter\Http\Controllers\Admin\UserFilterCrudController;
use Modules\Filter\Http\Livewire\FilterItemArticles;
use Modules\Filter\Http\Livewire\FilterItemPage;
use Modules\Filter\Http\Livewire\FilterItemService;
use Modules\Filter\Http\Livewire\FilterPage;

Route::group([
    'middleware'=> array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::post('api/filter-item',[FilterItemController::class, 'index'] );
    Route::post('api/filter-item/{id}', [FilterItemController::class, 'show']);

    Route::group(['prefix'=>'/section/{filter:slug}','as'=>'filter.'], function() {
        Route::get('/', FilterPage::class)->name('page');
        Route::get('/{filterItem:slug}', FilterItemPage::class)->name('item.page');
        Route::get('/{filterItem:slug}/mag', FilterItemArticles::class)->name('item.articles');
        Route::get('/{filterItem:slug}/services', FilterItemService::class)->name('item.services');
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
    Route::crud('resource/filter', UserFilterCrudController::class);
    Route::crud('resource/filteritem', UserFilterItemCrudController::class);
    Route::crud('filter', FilterCrudController::class);
    Route::crud('filteritem', FilterItemCrudController::class);
});
