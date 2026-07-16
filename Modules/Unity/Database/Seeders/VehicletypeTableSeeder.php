<?php

namespace Modules\Unity\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class VehicletypeTableSeeder extends Seeder
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
                'name'     => 'vehicletype list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست انواع وسایل نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'vehicletype create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن نوع وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'vehicletype update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش نوع وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'vehicletype delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف نوع وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'vehicletype setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات نوع وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'vehicletype clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن نوع وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'vehicletype revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های نوع وسیله نقلیه',
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
