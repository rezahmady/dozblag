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
    protected $signature = 'updater:core';

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
        // composer update
        exec('cd '.base_path().' && composer update');

        chmod(base_path(),0755);

        // optimize
        $this->call('optimize:clear');

        // migrations
        $this->call('migrate');

        // cache config
        $this->call('cahe:config');

        // cache routes
        $this->call('cahe:route');

        // cache views
        $this->call('cahe:view');

        // cache events
        $this->call('cahe:event');

        // seed core
        $this->call('db:seed');

        // seed modules
        $this->call('module:seed');

    }
}
