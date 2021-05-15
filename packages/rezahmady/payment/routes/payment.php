<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Payment Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Payment package.
|
*/

/**
 * User Routes
 */

use Illuminate\Http\Request;
use Rezahmady\Payment\Http\Controllers\Admin\DiscountCrudController;
use Rezahmady\Payment\Http\Controllers\Admin\InvoiceCrudController;
use Rezahmady\Payment\Http\Controllers\Admin\TransactionCrudController;
use Rezahmady\Payment\Http\Controllers\PaymentController;

Route::group([
    'middleware'=> array_merge(
    	(array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::middleware('payment-configs')->get('/payment/{driver}/{invoice}', [PaymentController::class, 'payment']);
    Route::middleware('payment-configs')->any('/callback', [PaymentController::class,'callback'])->name('payment.callback');
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
    Route::crud('transaction', TransactionCrudController::class);
    Route::crud('invoice', InvoiceCrudController::class);
    Route::crud('discount', DiscountCrudController::class);
});