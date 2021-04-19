<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\User Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\User package.
|
*/

/**
 * User Routes
 */

use Rezahmady\User\Http\Livewire\Auth\Login;
use Rezahmady\User\Http\Livewire\Auth\Register;
use Rezahmady\User\Http\Livewire\DoctorProfile;

Route::group([
    'middleware'=> array_merge(
    	(array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {
    Route::group(['prefix'=>'auth','as'=>'auth.'], function() {
        Route::get('/login', Login::class)->name('login');
        Route::get('/register', Register::class)->name('register');
    });
    Route::get('/doctor/{user:id}', DoctorProfile::class)->name('doctor.show');  
    
    Route::group(['prefix'=>'api'], function(){
        Route::get('/users', 'UserController@users');
        Route::get('/doctors', 'UserController@doctors');
        Route::get('/operators', 'UserController@operators');
        Route::post('/doctor', 'DoctorController@index');
        Route::post('/doctor/{id}', 'DoctorController@show');
        Route::middleware('auth:api')->get('/user', function (Request $request) {
            return $request->user();
        });
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
    Route::crud('permission', \Rezahmady\User\Http\Controllers\Admin\PermissionCrudController::class);
    Route::crud('role', \Rezahmady\User\Http\Controllers\Admin\RoleCrudController::class);
    Route::crud('user', \Rezahmady\User\Http\Controllers\Admin\UserCrudController::class);
});