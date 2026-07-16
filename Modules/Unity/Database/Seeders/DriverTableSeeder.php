<?php

namespace Modules\Unity\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class DriverTableSeeder extends Seeder
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
                'name'     => 'driver list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست رانندگان',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'driver create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'driver update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'driver delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'driver setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات رانندگان',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'driver clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'driver revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های رانندگان',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'driver manage all',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت رانندگان همه شرکت ها',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'driver change unity',
                'guard_name'    => 'web',
                'display_name'   => 'امکان جابجایی راننده بین شرکت ها',
                'module'    => 'Unity',
            ],

        ]);

        $permissions = Permission::where('module', 'Unity')->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insertOrIgnore([
                'role_id'   => Role::first()->id,
                'permission_id' => $permission->id
            ]);
        }
    }
}
