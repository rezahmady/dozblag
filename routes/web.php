<?php

use App\Http\Controllers\FormController;
use App\Http\Livewire\Home;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\UploadController;
use App\Models\User;
use App\Services\Telegram\Telegram;
use Rezahmady\Filter\Models\FilterItem;
use Rezahmady\Page\Http\Livewire\PageRender;

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

Route::get('/set-slug', function () {
    // event(new \App\Events\SystemMessage());
    // return 'ok';
    // $user = App\Models\User::first();
    // $user->notify(new App\Notifications\InvoicePaid());
    $filteritems = FilterItem::get();
    foreach($filteritems as $post) {
        $slug = SlugService::createSlug(FilterItem::class, 'slug', $post->name);
        $post->update(['slug' => $slug]);
    }
});

Route::get('/admin/aa', function() {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');

    $time = date('r');
    echo "data: {$time}\n\n";
    flush();
});

// At the top of the file.
Route::post('/upload/voice', [UploadController::class, 'voice']);


// Download Route
Route::get('download', function(Request $request)
{
    $filename = $request->filename;

    // Check if file exists in app/storage/file folder
    $file_path = public_path($filename)  ;
    // ddd($file_path);
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, basename($filename), [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
});

Route::get('{modelPage}/{subs?}', PageRender::class)
->where(['modelPage' => '^(((?=(?!admin)(?!doctor)(?!auth)(?!profile))(?=(?!\/)).))*$', 'subs' => '.*'])
->name('page');

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/




