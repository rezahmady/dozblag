<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\UploadController;
use Modules\Filter\Models\FilterItem;
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
Route::post('/upload/voice', [UploadController::class, 'voice']);

Route::get('/test', function(Request $request) {

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    $allResults = [];

    for($page = 1; $page<= 25; $page++) {

        $res =  \Illuminate\Support\Facades\Http::asForm()->post('https://www.paziresh24.com/api/searchV3', [
            'route' => '/s/ir/center/?page='.$page,
        ]);
        $resBody = json_decode($res->body());

        if(isset($resBody->result)) {
            $items = $resBody->result;

        } else {
            dd($resBody);
        }

        foreach ($items as $item) {

            $image = str_replace('/api/getImage/p24/search-hospitalclinic/', '', $item->image);

            if($image != 'noimage.png') {
                \Illuminate\Support\Facades\Storage::disk('local')->put('/uploads/images/resource/'.$image, file_get_contents('https://www.paziresh24.com'.$item->image));
                $image_name = '/uploads/images/resource/'.$image;
            }

//            $client = new \Goutte\Client();
//            $crawler = $client->request('GET', $item->center_url);
//            $crawler->filter('.wrapper_indent')->each(function ($node) use ($item) {
//                $item->bio = $node->html();
//            });
//
//            $crawler->filter('script')->each(function ($node) use ($item) {
//                $lat = get_string_between($node->html(),'"lat":"','"');
//                $lon = get_string_between($node->html(),'"lon":"','"');
//                if(strlen($lat) > 3) {
//                    $item->lat = $lat;
//                }
//                if(strlen($lon) > 3) {
//                    $item->lon = $lon;
//                }
//            });

            $template = ($item->center_id == 2) ? 'hospital' : 'clinic';

            $shahrestan_id = null;
            $ostan_id = null;
//            if($item->province === 'کهکیلویه و بویراحمد') {
//                $ostan_id = 23;
//            } elseif($item->province === 'چهارمحال بختیاری') {
//                $ostan_id = 9;
//            } else {
//                $ostan = \App\Models\Ostan::where('name', 'like', '%'.$item->province.'%')->first();
//                if($ostan) $ostan_id = $ostan->id;
//            }
//            if($ostan_id) {
//                $shahrestan = \App\Models\Shahrestan::where('ostan_id', $ostan_id)->where('name', $item->city)->first();
//                if($shahrestan) $shahrestan_id = $shahrestan->id;
//            } else {
//                $ostan_id = $shahrestan_id = null;
//            }

            $extras = [
                'bio' => $item->bio ?? '',
                'profile' => $image_name ?? '',
                'ostan_id' => $ostan_id,
                'shahrestan_id' => $shahrestan_id,
                'address' => $item->address,
                'phone' => $item->tell,
                'lat' => $item->lat ?? '',
                'lon' => $item->lon ?? '',
                'filter_services' => [],
                'meta_title' => $item->display_name,
                'meta_description' => '',
                'meta_keywords' => '',
                'src_slug' => $item->slug,
                'src_id' => $item->id,
            ];

//            $resource = new \Modules\Resource\Models\Resource();
//            $resource->name = $item->name;
//            $resource->template = $template;
//            $resource->extras = $extras;
//            $resource->save();

            $item->extras = $extras;
        }
        $allResults= array_merge($allResults, $items) ;
    }


    dd($allResults);




//    dd(json_decode($res->body()));

});


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

Route::post('/admin/api/widget', [ \App\Http\Controllers\Api\DashboardController::class, 'update_widget']);

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/




