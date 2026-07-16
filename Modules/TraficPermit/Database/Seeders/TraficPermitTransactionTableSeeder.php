<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class TraficPermitTransactionTableSeeder extends Seeder
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
                'name'     => 'TraficPermitTransaction list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست تراکنش‌ها',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitTransaction create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن تراکنش',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitTransaction update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش تراکنش',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitTransaction delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف تراکنش',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitTransaction setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات تراکنش',
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
