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

use Illuminate\Http\Request;
use Modules\Payment\Http\Controllers\Admin\DiscountCrudController;
use Modules\Payment\Http\Controllers\Admin\InvoiceCrudController;
use Modules\Payment\Http\Controllers\Admin\TransactionCrudController;
use Modules\Payment\Http\Controllers\PaymentController;

Route::group([
    'middleware'=> array_merge(
        (array) config('backpack.base.web_middleware', 'web')
    )
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
