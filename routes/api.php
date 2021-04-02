<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/users', 'UserController@users');
Route::get('/doctors', 'UserController@doctors');
Route::get('/operators', 'UserController@operators');
Route::post('/shahrestan', 'ShahrestanController@index');
Route::post('/shahrestan/{id}', 'ShahrestanController@show');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
