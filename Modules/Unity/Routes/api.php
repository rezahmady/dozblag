<?php

use Illuminate\Http\Request;
use Modules\Unity\Http\Controllers\DriverOrderController;
use Modules\Unity\Http\Controllers\TruckController;
use Modules\Unity\Http\Controllers\TruckOrderController;

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

// Route::middleware('auth:api')->get('/admin/unity', function (Request $request) {
//     return $request->user();
// });

Route::post('unity/truck-sysadminii', [TruckController::class, 'index'] );
Route::post('unity/truck-sysadminii/{id}', [TruckController::class, 'show'] );

Route::post('unity/trailer-sysadminii', [\Modules\Unity\Http\Controllers\TrailerController::class, 'index'] );
Route::post('unity/trailer-sysadminii/{id}', [\Modules\Unity\Http\Controllers\TrailerController::class, 'show'] );


Route::post('unity/truck-order', [TruckOrderController::class, 'index'] );
Route::post('unity/truck-order/{id}', [TruckOrderController::class, 'show'] );


Route::post('unity/driver-order', [DriverOrderController::class, 'index'] );
Route::post('unity/driver-order/{id}', [DriverOrderController::class, 'show'] );
