<?php

use Modules\User\Http\Controllers\Api\DoctorController;
use Modules\User\Http\Controllers\Api\UserController;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Http\Livewire\Auth\Login;
use Modules\User\Http\Livewire\DoctorList;
use Modules\User\Http\Livewire\DoctorProfile;


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

Route::group([
    'middleware'=> array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::group(['prefix'=>'auth','as'=>'auth.'], function() {
        Route::middleware('guest')->get('/login', Login::class)->name('login');
        Route::middleware('auth')->get('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::group(['prefix'=>'doctor','as'=>'doctor.'], function() {
        Route::get('/', DoctorList::class)->name('list');
        Route::get('/{user:slug}', DoctorProfile::class)->name('show');
    });


    Route::group(['prefix'=>'api'], function(){
        Route::get('/users', [UserController::class, 'users']);
        Route::get('/doctors', [UserController::class, 'doctors']);
        Route::get('/operators', [UserController::class, 'operators']);
        Route::post('/doctor', [DoctorController::class, 'index']);
        Route::post('/doctor/{id}', [DoctorController::class, 'show']);
        Route::middleware('auth:api')->get('/user', function (Request $request) {
            return $request->user();
        });
    });

    // Route::middleware('auth')->group(['prefix'=>'profile'], function(){
    //     // Route::get('/personal-info', 'UserController@users');
    //     // Route::get('/medical-info', 'UserController@users');
    // });
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
    Route::crud('permission', \Modules\User\Http\Controllers\Admin\PermissionCrudController::class);
    Route::crud('role', \Modules\User\Http\Controllers\Admin\RoleCrudController::class);
    Route::crud('user', \Modules\User\Http\Controllers\Admin\UserCrudController::class);
    Route::get('user/loginAsUser/{user:id}', [\Modules\User\Http\Controllers\AuthController::class, 'loginOperatorAsUser']);
    // Route::post('/resource/inline/create/modal', [ResourceCrudController::class, 'setupInlineCreateOperation'])->name('resources-inline-create');
    // Route::post('/resource/inline/create', [ResourceCrudController::class, 'storeInlineCreate'])->name('resources-inline-create-save');
});
