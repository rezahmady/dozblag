<?php

namespace Modules\TraficPermit\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\TraficPermit\Enums\TransactionType;
use Modules\TraficPermit\Models\TraficPermitExport;
use Modules\TraficPermit\Models\Transaction;
use Modules\Unity\Models\Unity;

class Checkout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'traficpermit:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'checkout unities account';

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
        // Log::info('unity_id: '. $this->argument('unity'));

        $unities = Unity::all(); 
        foreach ($unities as $unity) {
            $unity_id = $unity->id;
            $exports = TraficPermitExport::whereExists(function ($query) use($unity_id) {
                $query
                ->select(DB::raw('*'))
                ->from('permit_orders')
                ->whereColumn('permit_orders.id', 'permit_order_id')
                ->where('permit_order_trafic_permit.status', 1)
                ->join('unities', 'unities.id', '=', 'permit_orders.unity_id')
                ->where('unities.id', $unity_id);
            })

            ->doesntHave('transactions', 'and', function($q){
                $q->where('status', 1);
            })
            ->get();

            //$wallet = Transaction::where('unity_id', $unity_id)->where('type', TransactionType::Deposit)->sum('amount') - Transaction::where('unity_id', $unity_id)->where('type', TransactionType::Withdraw)->sum('amount');

            foreach($exports as $export) {
               // if($export->amount > $wallet) break;

                DB::transaction(function () use ($export, $unity_id) {

                    Transaction::create([
                        'unity_id' => $unity_id,
                        'type' => TransactionType::Withdraw,
                        'amount' => $export->amount,
                        'trafic_permit_export_id' => $export->id
                    ]);

                }, 3);

                //$wallet = $wallet - $export->amount;
            }
        }


    //     $unities = Unity::all();

    // foreach($unities as $unity) {

    //     if($unity->orders->exists()) {
    //         $groups = $unity->orders->groupBy(function($val) {
    //             return Carbon::parse($val->created_at)->format('Y');
    //         });
    //         if($groups) foreach($groups as $year => $orders) {
    //             if($orders) foreach($orders as $i => $order) {
    //                 $order->update([
    //                     'ordernumber' => substr($year, -2).$unity->id.'/'.$i+1
    //                 ]);
    //             }
    //         }
    //     }
    
    // }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            // ['unity', InputArgument::REQUIRED, 'unity id'],
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
