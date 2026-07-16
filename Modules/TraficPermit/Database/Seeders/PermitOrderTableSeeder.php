<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class PermitOrderTableSeeder extends Seeder
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
                'name'     => 'PermitOrder list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست درخواست های مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'PermitOrder create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن درخواست مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'PermitOrder update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش درخواست مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'PermitOrder delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف درخواست مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'PermitOrder setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات درخواست های مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'PermitOrder clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن درخواست مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'PermitOrder revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های درخواست های مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'PermitOrder special',
                'guard_name'    => 'web',
                'display_name'   => 'امکان درخواست ویژه بدون محدودیت',
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
