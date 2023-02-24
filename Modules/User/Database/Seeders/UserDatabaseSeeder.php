<?php

namespace Modules\User\Database\Seeders;

use Database\Seeders\ModuleSeeder;
use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class UserDatabaseSeeder extends Seeder
{
    use SeederOnce;
    
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
