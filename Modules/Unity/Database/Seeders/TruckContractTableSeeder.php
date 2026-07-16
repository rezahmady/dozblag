<?php

namespace Modules\Unity\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class TruckContractTableSeeder extends Seeder
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
                'name'     => 'truckcontract list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست قرارداد وسایل نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truckcontract create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن قرارداد وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truckcontract update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش قرارداد وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truckcontract delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف قرارداد وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truckcontract setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات قرارداد وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truckcontract clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن قرارداد وسیله نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truckcontract revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های قرارداد وسایل نقلیه',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truckcontract manage all',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت قرارداد وسایل نقلیه همه شرکت ها',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'truckcontract termination',
                'guard_name'    => 'web',
                'display_name'   => 'فسخ قرارداد وسیله نقلیه',
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
