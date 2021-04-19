<?php

/*
|--------------------------------------------------------------------------
| Rezahmady\Comment Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Rezahmady\Comment package.
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
    Route::crud('article/comment', \Rezahmady\Comment\Http\Controllers\Admin\CommentCrudController::class);
    Route::get('article/comment/{comment:id}/approvedComment', [\Rezahmady\Comment\Http\Controllers\Admin\CommentCrudController::class, 'approvedComment']);
    Route::get('article/comment/{comment:id}/rejectComment', [\Rezahmady\Comment\Http\Controllers\Admin\CommentCrudController::class, 'rejectComment']);
    Route::crud('user/doctor/comment', \Rezahmady\Comment\Http\Controllers\Admin\CommentDoctorCrudController::class);
});