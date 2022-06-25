<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CoreUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updater:core {--u}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run after update (run migrations, seeds and etc.)';

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
        if($this->option('u') === null) {
            // composer update
            exec('cd '.base_path().' && composer update');

            // publish backpack assets
            $this->call('backpack:fix');
        }

        chmod(base_path(),0755);

        // optimize
        $this->call('optimize:clear');

        // migrations
        $this->call('migrate');


        // cache config
        $this->call('config:cache');

        // cache routes
        $this->call('route:cache');

        // cache views
        $this->call('view:cache');

        // cache events
        $this->call('event:cache');

        // seed core
        $this->call('db:seed');

        // seed modules
        $this->call('module:seed');

        $this->call('optimize');
    }
}
