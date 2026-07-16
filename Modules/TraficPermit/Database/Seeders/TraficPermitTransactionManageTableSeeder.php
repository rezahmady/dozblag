<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class TraficPermitTransactionManageTableSeeder extends Seeder
{
    use SeederOnce;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('permissions')->insertOrIgnore([
            [
                'name'     => 'TraficPermitTransaction manage all',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت تراکنش همه شرکت‌ها',
                'module'    => 'TraficPermit',
            ],
        ]);

        $permissions = Permission::where('module', 'TraficPermit')->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insertOrIgnore([
                'role_id'   => Role::first()->id,
                'permission_id' => $permission->id
            ]);
        }
    }
}
