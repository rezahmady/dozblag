<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetResourcesFromPaziresh24 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resources:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get all resources from paziresh24.com website';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            Log::info('start generate paziresh24.com');

            $results = [] ;

            $res =  \Illuminate\Support\Facades\Http::asForm()->post('https://www.paziresh24.com/api/searchV3?page=5', [
                'route' => '/s/ir/center/?page=1'
            ]);
            $body = json_decode($res->body());

            $totalCount = $body->totalCount;

            function get_string_between($string, $start, $end){
                $string = ' ' . $string;
                $ini = strpos($string, $start);
                if ($ini == 0) return '';
                $ini += strlen($start);
                $len = strpos($string, $end, $ini) - $ini;
                return substr($string, $ini, $len);
            }

            $allResults = [];

            for($page = 1; $page<= $totalCount; $page++) {

                $res =  \Illuminate\Support\Facades\Http::asForm()->post('https://www.paziresh24.com/api/searchV3?page=5', [
                    'route' => '/s/ir/center/?page='.$page,
                ]);
                $resBody = json_decode($res->body());

                $items = $resBody->result;

//        foreach ($items as $item) {
//            $client = new \Goutte\Client();
//            $crawler = $client->request('GET', 'https://www.paziresh24.com/'.$item->slug);
//            $crawler->filter('.wrapper_indent')->each(function ($node) use ($item) {
//                $item->bio = $node->html();
//            });
//
//            $crawler->filter('script')->each(function ($node) use ($item) {
//                $lat = get_string_between($node->html(),'"lat":"','"');
//                $lon = get_string_between($node->html(),'"lon":"','"');
//                if($lat) {
//                    $item->lat = $lat;
//                }
//                if($lon) {
//                    $item->lon = $lon;
//                }
//            });
//        }
                foreach ($items as $item) {

                    $template = ($item->center_id == 2) ? 'hospital' : 'clinic';

                    $shahrestan_id = null;
                    $ostan_id = null;
                    if($item->province === 'کهکیلویه و بویراحمد') {
                        $ostan_id = 23;
                    } elseif($item->province === 'چهارمحال بختیاری') {
                        $ostan_id = 9;
                    } else {
                        $ostan = \App\Models\Ostan::where('name', 'like', '%'.$item->province.'%')->first();
                        if($ostan) $ostan_id = $ostan->id;
                    }
                    if($ostan_id) {
                        $shahrestan = \App\Models\Shahrestan::where('ostan_id', $ostan_id)->where('name', $item->city)->first();
                        if($shahrestan) $shahrestan_id = $shahrestan->id;
                    } else {
                        $ostan_id = $shahrestan_id = null;
                    }

                    $extras = [
                        'bio' => '',
                        'profile' => $item->image,
                        'ostan_id' => $ostan_id,
                        'shahrestan_id' => $shahrestan_id,
                        'address' => $item->address,
                        'phone' => $item->tell,
                        'lat' => '',
                        'lon' => '',
                        'filter_services' => [],
                        'meta_title' => $item->display_name,
                        'meta_description' => '',
                        'meta_keywords' => '',
                        'src_slug' => $item->slug,
                        'src_id' => $item->id,
                    ];

                    $resource = new \Modules\Resource\Models\Resource();
                    $resource->name = $item->name;
                    $resource->template = $template;
                    $resource->extras = $extras;
                    $resource->save();

                }
                $allResults= array_merge($allResults, $items) ;

                sleep(5);
            }

            Log::info('save '.sizeof($allResults).' resource from '.$totalCount.' center');

        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
        }
    }
}
