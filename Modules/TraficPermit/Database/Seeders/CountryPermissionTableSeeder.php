<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class CountryPermissionTableSeeder extends Seeder
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
        // Country permission
        DB::table('permissions')->insertOrIgnore([
            [
                'name'     => 'Country list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست کشورها',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Country create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن کشور',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Country update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش کشور',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Country delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف کشور',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Country setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات کشورها',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Country clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن کشور',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Country revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های کشور',
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
