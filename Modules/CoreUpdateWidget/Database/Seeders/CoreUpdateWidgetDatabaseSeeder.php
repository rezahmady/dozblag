<?php

namespace Modules\CoreUpdateWidget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CoreUpdateWidgetDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(WidgetTableSeeder::class);
    }
}
