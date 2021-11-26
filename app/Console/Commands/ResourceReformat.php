<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Resource\Models\Resource;

class ResourceReformat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resources:reformat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reformat resource module data';

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
        // template
        $resources = Resource::where('template', '!=', 'hospital')->where('name', 'like', '%یمارستان%')->get();
        foreach ($resources as $resource) {
            $resource->update([
                'template' => 'hospital'
            ]);
        }

        // bio
        $resources = Resource::get();
        foreach ($resources as $resource) {
            $style = $this->get_string_between($resource->extras->bio, 'style="', '"', );
            if(strlen($style)> 2) {
                $bio = str_replace($style, '', $resource->extras->bio);
                $resource->update([
                    'extras->bio' => $bio
                ]);
            }
        }
    }

    public function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
