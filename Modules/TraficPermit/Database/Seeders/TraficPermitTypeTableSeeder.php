<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class TraficPermitTypeTableSeeder extends Seeder
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
                'name'     => 'TraficPermitType list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست انواع مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitType create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن نوع جدید مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitType update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش نوع مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitType delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف نوع مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitType setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات انواع مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitType clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن نوع مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'TraficPermitType revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های انواع مجوز',
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
