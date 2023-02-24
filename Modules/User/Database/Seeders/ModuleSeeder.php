<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class ModuleSeeder extends Seeder
{
    use SeederOnce;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name'     => 'module manage',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت افزونه‌ها',
                'module'    => 'modules',
            ],
            [
                'name'     => 'module create',
                'guard_name'    => 'web',
                'display_name'   => 'نصب افزونه',
                'module'    => 'modules',
            ],
            [
                'name'     => 'module delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف افزونه',
                'module'    => 'modules',
            ],
        ]);

        $permissions = Permission::where('module', 'modules')->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insertOrIgnore([
                'role_id'   => 1,
                'permission_id' => $permission->id
            ]);
        }

        // DB::table('modules')->insert([
        //     [
        //         'name'     => 'User',
        //         'display_name'   => 'کاربران',
        //         'status'    => 1,
        //     ],
        //     [
        //         'name'     => 'ThemeManager',
        //         'display_name'   => 'مدیریت قالب',
        //         'status'    => 1,
        //     ],
        // ]);
    }
}
