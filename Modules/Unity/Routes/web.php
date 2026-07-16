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
 * Admin Routes
 */

use Illuminate\Support\Facades\Route;
use Modules\Unity\Http\Controllers\Admin\DriverContractCrudController;
use Modules\Unity\Http\Controllers\Admin\TruckContractCrudController;
use Modules\Unity\Http\Controllers\Admin\DriverCrudController;
use Modules\Unity\Http\Controllers\Admin\TruckCrudController;
use Modules\Unity\Http\Controllers\Admin\UnityCrudController;
use Modules\Unity\Http\Controllers\Admin\VehiclebrandCrudController;
use Modules\Unity\Http\Controllers\Admin\VehicletypeCrudController;
use Modules\Unity\Http\Controllers\Admin\TrailerCrudController;

Route::group(
    [
        'middleware' => array_merge(
            (array) config('backpack.base.web_middleware', 'web'),
            [
                \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            ]
        ),
        'prefix'     => config('backpack.base.route_prefix', 'admin'),
    ],
function () {

    // Registration Routes...
    Route::get('register-unity', 'Modules\Unity\Http\Controllers\Admin\Auth\RegisterController@showRegistrationForm')->name('unity.auth.register');
    Route::post('register-unity', 'Modules\Unity\Http\Controllers\Admin\Auth\RegisterController@register');
    Route::get('/debug-unity', function() {
        $unity = 33;
        $search_term = '47A';
        $options = \Modules\Unity\Models\Truck::query();
        $options = $options->where('unity_id', $unity);
        $options = $options->where('transit_number', 'LIKE', '%'.$search_term.'%');
        $options = $options->whereExists(function ($query) {
            $query->select(DB::raw('*'))
                ->from('permit_orders')
                ->whereNull('permit_orders.deleted_at')
                ->whereColumn('permit_orders.truck_id', 'trucks.id')
                ->join('permit_order_trafic_permit', 'permit_order_trafic_permit.permit_order_id', '=', 'permit_orders.id')
                ->where('permit_order_trafic_permit.status', 1)
                ->whereNull('permit_order_trafic_permit.get_carcasses_at');
            // ->join('trafic_permits', 'trafic_permits.id', '=', 'permit_order_trafic_permit.trafic_permit_id')
            // ->where('trafic_permits.status', 'issued');
        });
        dd($options->pluck('transit_number')->toArray());
    });

});

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
], function () {
    Route::crud('unity', UnityCrudController::class);
    Route::crud('truck', TruckCrudController::class);
    Route::crud('truckcontract', TruckContractCrudController::class);
    Route::crud('driver', DriverCrudController::class);
    Route::crud('vehicletype', VehicletypeCrudController::class);
    Route::crud('vehiclebrand', VehiclebrandCrudController::class);
    Route::crud('drivercontract', DriverContractCrudController::class);
    Route::crud('trailer', TrailerCrudController::class);
});
