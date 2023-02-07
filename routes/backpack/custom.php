<?php

use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\ModuleCrudController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

//Route::get('admin/register', [RegisterController::class, 'showRegistrationForm'])->name('backpack.auth.register');


Route::group(
    [
        // 'namespace'  => 'Backpack\CRUD\app\Http\Controllers',
        'middleware' => config('backpack.base.web_middleware', 'web'),
        'prefix'     => config('backpack.base.route_prefix'),
    ],
function () {
    // Authentication Routes...
    Route::get('login', 'Backpack\CRUD\app\Http\Controllers\Auth\LoginController@showLoginForm')->name('backpack.auth.login');
    Route::post('login', 'Backpack\CRUD\app\Http\Controllers\Auth\LoginController@login');
    Route::get('logout', 'Backpack\CRUD\app\Http\Controllers\Auth\LoginController@logout')->name('backpack.auth.logout');
    Route::post('logout', 'Backpack\CRUD\app\Http\Controllers\Auth\LoginController@logout');

    // Registration Routes...
    Route::get('register', 'App\Http\Controllers\Admin\Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
    Route::post('register', 'App\Http\Controllers\Admin\Auth\RegisterController@register');

    // if not otherwise configured, setup the password recovery routes
    if (config('backpack.base.setup_password_recovery_routes', true)) {
        Route::get('password/reset', 'Backpack\CRUD\app\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('backpack.auth.password.reset');
        Route::post('password/reset', 'Backpack\CRUD\app\Http\Controllers\Auth\ResetPasswordController@reset');
        Route::get('password/reset/{token}', 'Backpack\CRUD\app\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('backpack.auth.password.reset.token');
        Route::post('password/email', 'Backpack\CRUD\app\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('backpack.auth.password.email')->middleware('backpack.throttle.password.recovery:'.config('backpack.base.password_recovery_throttle_access'));
    }
});

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('module/{module}/enable', [ ModuleCrudController::class, 'enable'])->name('enable');
    Route::get('module/{module}/disable', [ ModuleCrudController::class, 'disable'])->name('disable');
    Route::crud('module', 'ModuleCrudController');
    Route::crud('message', 'MessageCrudController');
    Route::get('message/{message:id}/toggleSeen', 'MessageCrudController@toggleSeen');
}); // this should be the absolute last line of this file