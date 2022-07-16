<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CoreInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install core';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('core:update', [
            '--composer' => true
        ]);
    }
}
