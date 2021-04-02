<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('tag', 'TagCrudController');
    Route::crud('article', 'ArticleCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::get('charts/weekly-users', 'Charts\WeeklyUsersChartController@response')->name('charts.weekly-users.index');
    Route::crud('product', 'ProductCrudController');
    Route::crud('filter', 'FilterCrudController');
    Route::crud('filteritem', 'FilterItemCrudController');
    Route::crud('theme', 'ThemeCrudController');
    Route::get('theme/{theme_folder}/activate', 'ThemeCrudController@activate');
    Route::get('theme/{theme}/rebuild', 'ThemeCrudController@rebuild');
    Route::crud('widget', 'WidgetCrudController');
    Route::crud('menu', 'MenuCrudController');
    Route::crud('message', 'MessageCrudController');
    Route::get('message/{message:id}/toggleSeen', 'MessageCrudController@toggleSeen');
    Route::crud('article/comment', 'CommentCrudController');
    Route::get('article/comment/{comment:id}/approvedComment', 'CommentCrudController@approvedComment');
    Route::get('article/comment/{comment:id}/rejectComment', 'CommentCrudController@rejectComment');
    Route::crud('user/doctor/comment', 'CommentDoctorCrudController');
    Route::crud('room', 'RoomCrudController');
    Route::crud('chat', 'ChatCrudController');
    Route::crud('resource/filter', 'UserFilterCrudController');
    Route::crud('resource/filteritem', 'UserFilterItemCrudController');
}); // this should be the absolute last line of this file
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Livewire\Chat',
], function () { // custom admin routes
    Route::get('chats', 'Index')->name('chat.index');
});
