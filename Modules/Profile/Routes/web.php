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

use Modules\Profile\Http\Controllers\Livewire\Dashboard;
use Modules\Profile\Http\Controllers\Livewire\Info;
use Modules\Profile\Http\Controllers\Livewire\Medical;

Route::group([
    'middleware'=> array_merge(
        ['web', 'auth']
    ),
    'prefix' => 'profile',
    'as' => 'profile.',
], function() {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/info', Info::class)->name('info');
    Route::get('/medical_folder', Medical::class)->name('medical');
});
