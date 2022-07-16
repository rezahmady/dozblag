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
    protected $signature = 'core:update {--composer} {--dev}';

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

            $owner = get_current_user();

            // composer update
            // fix permissions
            exec('cd '.base_path().' && chown -R '.$owner.':www-data storage && chown -R '.$owner.':www-data bootstrap/cache  && chmod -R 775 storage && chmod -R 775 bootstrap/cache');

            // publish backpack assets
            $this->call('vendor:publish', [
                '--provider' => 'Backpack\CRUD\BackpackServiceProvider',
                '--tag' => 'public',
                '--force' => 'true',
            ]);

            //$this->call('backpack:filemanager:install');

            $this->call('module:enable User');
            $this->call('module:enable ThemeManager');

            chmod(base_path(),0755);
        }

        // migrations
        $this->call('migrate');

        // seed core
        $this->call('db:seed');

        // seed modules
        $this->call('module:seed');

        //publish modules assets
        $this->call('module:publish');

        if($this->option('dev')) {
            $this->call('cache:clear');
            $this->call('config:clear');
            $this->call('view:clear');
            $this->call('route:clear');
        } else {
            // optimize for production mode
            $this->call('optimize');
            // cache views
            $this->call('view:cache');
            // cache events
            $this->call('event:cache');
        }

    }
}
