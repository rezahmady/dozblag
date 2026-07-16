<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kdabrow\SeederOnce\SeederOnce;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class PageDatabaseSeeder extends Seeder
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

        DB::table('permissions')->insert([
            [
                'name'     => 'page manage',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت صفحات',
                'module'    => 'page',
            ],
            [
                'name'     => 'page list',
                'guard_name'    => 'web',
                'display_name'   => 'مشاهده لیست صفحات',
                'module'    => 'page',
            ],
            [
                'name'     => 'page create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن صفحه',
                'module'    => 'page',
            ],
            [
                'name'     => 'page update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش صفحه',
                'module'    => 'page',
            ],
            [
                'name'     => 'page delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف صفحه',
                'module'    => 'page',
            ],
            [
                'name'     => 'page setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات صفحه',
                'module'    => 'page',
            ],
            [
                'name'     => 'page clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن صفحه',
                'module'    => 'page',
            ],
            [
                'name'     => 'page revise',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نسخه‌های صفحه',
                'module'    => 'page',
            ],
            [
                'name'     => 'page create text',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن صفحه‌ی محتوایی',
                'module'    => 'page',
            ],
            [
                'name'     => 'page create blog',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن صفحه‌ی وبلاگی',
                'module'    => 'page',
            ],
            [
                'name'     => 'page create form',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن صفحه‌ی فرم',
                'module'    => 'page',
            ],
            [
                'name'     => 'page create link',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن صفحه‌ی لینک',
                'module'    => 'page',
            ],
        ]);

        $permissions = Permission::where('module', 'page')->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insertOrIgnore([
                'role_id'   => Role::first()->id,
                'permission_id' => $permission->id
            ]);
        }
    }
}
