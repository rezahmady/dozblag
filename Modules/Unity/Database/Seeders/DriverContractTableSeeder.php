<?php

namespace Modules\Unity\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class DriverContractTableSeeder extends Seeder
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
                'name'     => 'drivercontract list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست قرارداد رانندگان',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'drivercontract create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن قرارداد راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'drivercontract update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش قرارداد راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'drivercontract delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف قرارداد راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'drivercontract setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات قرارداد راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'drivercontract clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن قرارداد راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'drivercontract revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های قرارداد راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'drivercontract change status',
                'guard_name'    => 'web',
                'display_name'   => 'تغییر وضعیت راننده',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'drivercontract manage all',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت رانندگان همه شرکت ها',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'drivercontract termination',
                'guard_name'    => 'web',
                'display_name'   => 'فسخ قرارداد راننده',
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
