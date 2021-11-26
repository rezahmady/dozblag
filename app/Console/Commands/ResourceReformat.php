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
            $resource = $resource->withFakes();
            $bio = str_replace('font-family: IRANSans_FaNum;', '', $resource->bio);
            $resource->update([
               'extras->bio' => $bio
            ]);
        }
    }
}
