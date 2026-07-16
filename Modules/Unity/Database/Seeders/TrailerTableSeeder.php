<?php

namespace Modules\Unity\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class TrailerTableSeeder extends Seeder
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
                'name'     => 'Trailer list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست یدک ها',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Trailer create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن یدک',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Trailer update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش یدک',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Trailer delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف یدک',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Trailer setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات یدک ها',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Trailer clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن یدک',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Trailer revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های یدک ها',
                'module'    => 'Unity',
            ],
            [
                'name'     => 'Trailer manage all',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت یدک های همه شرکت ها',
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
