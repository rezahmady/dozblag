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


Route::group([
    'middleware'=> array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
], function() {

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
    Route::crud('article/comment', \Modules\Comment\Http\Controllers\Admin\CommentCrudController::class);
    Route::get('article/comment/{comment:id}/approvedComment', [\Modules\Comment\Http\Controllers\Admin\CommentCrudController::class, 'approvedComment']);
    Route::get('article/comment/{comment:id}/rejectComment', [\Modules\Comment\Http\Controllers\Admin\CommentCrudController::class, 'rejectComment']);
    Route::crud('user/doctor/comment', \Modules\Comment\Http\Controllers\Admin\CommentDoctorCrudController::class);
    Route::get('user/comment/{comment:id}/approvedComment', [\Modules\Comment\Http\Controllers\Admin\CommentDoctorCrudController::class, 'approvedComment']);
    Route::get('user/comment/{comment:id}/rejectComment', [\Modules\Comment\Http\Controllers\Admin\CommentDoctorCrudController::class, 'rejectComment']);
});
