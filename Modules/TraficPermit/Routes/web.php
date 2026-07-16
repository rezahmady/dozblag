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
    'namespace'  => 'Modules\TraficPermit\Http\Controllers',
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
    'namespace'  => 'Modules\TraficPermit\Http\Controllers\Admin',
], function () { // custom admin routes
    // routes
    Route::crud('trafic-permit', 'TraficPermitCrudController');
    Route::crud('trafic-permit-report', 'TraficPermitReportCrudController');
    Route::crud('repository', 'RepositoryCrudController');
    Route::crud('country', 'CountryCrudController');
    Route::crud('permit-order', 'PermitOrderCrudController');
    Route::crud('trafic-permit-type', 'TraficPermitTypeCrudController');
    Route::crud('trafic-permit-template', 'TraficPermitTemplateCrudController');
    Route::crud('trafic-permit-export', 'TraficPermitExportCrudController');
    Route::crud('corrected-export', 'CorrectedExportCrudController');
    Route::crud('total-trafic-permit-report', 'TotalTraficPermitReportCrudController');
    Route::crud('transaction', 'TransactionCrudController');
    Route::crud('trafic-permit-general', 'TraficPermitGeneralCrudController');
}); // this should be the absolute last line of this file
