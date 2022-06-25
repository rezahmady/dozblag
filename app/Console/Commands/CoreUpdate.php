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
    protected $signature = 'core:update {--composer}';

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
        if($this->option('composer')) {
            // composer update
            exec('cd '.base_path().' && composer update');

            // publish backpack assets
            $this->call('vendor:publish', [
                '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
                '--tag' => 'public',
                '--force' => 'true',
            ]);
            chmod(base_path(),0755);
        }      

        // migrations
        $this->call('migrate');

        // cache views
        $this->call('view:cache');

        // cache events
        $this->call('event:cache');

        // seed core
        $this->call('db:seed');

        // seed modules
        $this->call('module:seed');

        // optimize for production mode
        $this->call('optimize');

        //publish modules assets
        $this->call('module:publish');
    }
}
