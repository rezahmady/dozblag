<?php

use App\Http\Controllers\LangController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){
    return redirect()->to(backpack_url());
});

Route::post('/admin/api/widget', [ \App\Http\Controllers\Api\DashboardController::class, 'update_widget']);
Route::get('/admin/self-update', [ \App\Http\Controllers\Api\UpdateController::class, 'update']);
Route::post('/admin/api/self-update/check', [ \App\Http\Controllers\Api\UpdateController::class, 'check_update']);

// Multilanguge : change language
Route::get('lang/{locale}', [LangController::class, 'change'])->name('changeLang');

// Route::get('/fix-trailer', function () {
//     $trailers = \Modules\Unity\Models\Trailer::get();
//     foreach ($trailers as $trailer) {
//         if(isset($trailer->truck)) $trailer->update(['unity_id' => $trailer->truck->unity_id]);
//     }

//     $orders = \Modules\TraficPermit\Models\PermitOrder::get();
//     foreach ($orders as $order) {
//         $order->update(['trailer_id' => $order->truck->trailer->id]) ;
//     }
// });

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/




