<?php

namespace Modules\Unity\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class DefaultTableSeeder extends Seeder
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
                'name'     => 'Unity list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست مشتریان',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Unity create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن مشتری',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Unity update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش مشتری',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Unity delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف مشتری',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Unity setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات مشتریان',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Unity clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن مشتری',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Unity revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های مشتریان',
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
