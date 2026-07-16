<?php

namespace Modules\Unity\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class TruckTableSeeder extends Seeder
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
                'name'     => 'truck list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست وسایل نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truck create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truck update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truck delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truck setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات وسایل نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truck clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truck revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های وسایل نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truck change status',
                'guard_name'    => 'web',
                'display_name'   => 'تغییر وضعیت وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truck manage all',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت وسایل نقلیه همه شرکت ها',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truck change unity',
                'guard_name'    => 'web',
                'display_name'   => 'امکان جابحایی وسیله نقلیه بین شرکت ها',
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
