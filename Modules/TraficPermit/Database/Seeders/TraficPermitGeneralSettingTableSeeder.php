<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class TraficPermitGeneralSettingTableSeeder extends Seeder
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
                'name'         => 'TraficPermitGeneral setting',
                'guard_name'   => 'web',
                'display_name' => 'تنظیمات کلی مجوز تردد',
                'module'       => 'TraficPermit',
            ],
        ]);

        $permission = Permission::where('name', 'TraficPermitGeneral setting')->first();

        if ($permission && Role::first()) {
            DB::table('role_has_permissions')->insertOrIgnore([
                'role_id'       => Role::first()->id,
                'permission_id' => $permission->id,
            ]);
        }
    }
}
