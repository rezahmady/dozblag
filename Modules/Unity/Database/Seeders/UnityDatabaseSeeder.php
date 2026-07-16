<?php

namespace Modules\Unity\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UnityDatabaseSeeder extends Seeder
{
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(DefaultTableSeeder::class);
        $this->call(DriverTableSeeder::class);
        $this->call(DriverContractTableSeeder::class);
        $this->call(TruckTableSeeder::class);
        $this->call(TruckContractTableSeeder::class);
        $this->call(VehicletypeTableSeeder::class);
        $this->call(TrailerTableSeeder::class);
    }
}
