<?php

namespace Modules\User\Database\Seeders;

use Database\Seeders\ModuleSeeder;
use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(ModuleSeeder::class);
    }
}
