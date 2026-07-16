<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class RepositoryTableSeeder extends Seeder
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
                'name'     => 'Repository list',
                'guard_name'    => 'web',
                'display_name'   => 'لیست انبار',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Repository create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن دسته ای مجوز',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Repository update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش انبار مجوزها',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Repository delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف انبار مجوزها',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Repository setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات انبار مجوزها',
                'module'    => 'TraficPermit',
            ],
            [
                'name'     => 'Repository revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های انبار مجوزها',
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
