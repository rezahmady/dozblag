<?php

use Illuminate\Http\Request;
use Modules\TraficPermit\Http\Controllers\TraficPermitController;
use Modules\TraficPermit\Http\Controllers\TraficPermitTemplateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('traficpermit/trafic-permit-template', [TraficPermitTemplateController::class, 'index'] );
Route::post('traficpermit/trafic-permit-template/{id}', [TraficPermitTemplateController::class, 'show'] );
Route::post('traficpermit/for-print', [TraficPermitController::class, 'forprint']);
Route::post('traficpermit/print', [TraficPermitController::class, 'print']);
Route::post('traficpermit/report', [TraficPermitController::class, 'report']);
Route::post('traficpermit/remove', [TraficPermitController::class, 'remove']);
Route::post('traficpermit/all', [TraficPermitController::class, 'all']);