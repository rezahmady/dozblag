<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class DefaultDatabaseSeeder extends Seeder
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
                'name'     => 'TraficPermit list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست مجوزات',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermit create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermit update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermit delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermit setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات مجوزات',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermit revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های مجوزات',
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
