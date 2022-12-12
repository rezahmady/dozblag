<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\UploadController;
use Spatie\Sitemap\SitemapIndex;

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
use \Cviebrock\EloquentSluggable\Services\SlugService;


Route::get('/admin/generate-sitemap', function() {
    SitemapIndex::create()
    ->add('/sitemap/posts_sitemap.xml')
    ->add('/sitemap/doctors_sitemap.xml')
    ->add('/sitemap/resources_sitemap.xml')
    ->add('/sitemap/tags_sitemap.xml')
    ->add('/sitemap/pages_sitemap.xml')
    ->writeToFile(public_path('sitemap.xml'));
});

// At the top of the file.
Route::post('/admin/upload/file', [UploadController::class, 'file']);

Route::get('/', function(){
    return redirect()->to('/admin');
});

Route::post('/admin/api/widget', [ \App\Http\Controllers\Api\DashboardController::class, 'update_widget']);
Route::get('/admin/self-update', [ \App\Http\Controllers\Api\UpdateController::class, 'update']);
Route::post('/admin/api/self-update/check', [ \App\Http\Controllers\Api\UpdateController::class, 'check_update']);

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/




