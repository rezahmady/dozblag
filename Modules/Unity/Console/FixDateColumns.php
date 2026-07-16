<?php

namespace Modules\Unity\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Unity\Models\DriverContract;
use Modules\Unity\Models\TruckContract;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FixDateColumns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'unity:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix unity.';

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
        $driver_contracts = DriverContract::all();
        foreach($driver_contracts as $item) {
            $item->update([
                'start_date' => (new Carbon($item->start_date))->timestamp
            ]);
        }

        $truck_contracts = TruckContract::all();
        foreach($truck_contracts as $item) {
            $item->update([
                'start_date' => (new Carbon($item->start_date))->timestamp
            ]);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            // ['example', InputArgument::REQUIRED, 'An example argument.'],
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
            // ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
