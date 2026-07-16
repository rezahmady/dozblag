<?php

namespace Modules\TraficPermit\Console;

use Illuminate\Console\Command;
use Modules\TraficPermit\Enums\TraficPermitStatus;
use Modules\TraficPermit\Models\TraficPermit;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FixRecursive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'fix:recursive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
     * @return mixed
     */
    public function handle()
    {
        $traffic_permits = $this->withProgressBar(TraficPermit::all(), function (TraficPermit $traffic_permit) {
            if($traffic_permit->exports()->count()) {
                foreach ($traffic_permit->exports()->latest()->get() as $key => $export) {
                    if($traffic_permit->status === TraficPermitStatus::Active->value) {
                        $export->update(['is_recursive' => true]);
                    } elseif ($key != 0) {
                        $export->update(['is_recursive' => true]);
                    }
                }
            }
        });
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
//            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
