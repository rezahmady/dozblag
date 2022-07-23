<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Kdabrow\SeederOnce\SeederOnce;

class UserDatabaseSeeder extends Seeder
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

        DB::table('users')->insertOrIgnore([
            'name'     => 'sysadmin',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password'),
            'mobile'   => '0912000000',
        ]);


        DB::table('roles')->delete();
        DB::table('roles')->insertOrIgnore([
            'name'     => 'مدیر سیستم',
            'guard_name'    => 'web',
        ]);

        DB::table('model_has_roles')->insertOrIgnore([
            'role_id' => Role::where('name', 'مدیر سیستم')->first()->id,
            'model_type' => 'App\Models\User',
            'model_id' => User::first()->id,
        ]);

        DB::table('permissions')->insertOrIgnore([
            [
                'name'     => 'admin panel',
                'guard_name'    => 'web',
                'display_name'   => 'پنل مدیریت',
                'module'    => '',
            ],
            [
                'name'     => 'admin backup',
                'guard_name'    => 'web',
                'display_name'   => 'پشتیبان گیری',
                'module'    => '',

            ],
            [
                'name'     => 'admin log',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت لاگ های سیستم',
                'module'    => '',
            ],
            [
                'name'     => 'admin filemanager',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت فایل ها',
                'module'    => '',
            ],
            [
                'name'     => 'user manage',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت کاربران',
                'module'    => 'user',
            ],
            [
                'name'     => 'user list',
                'guard_name'    => 'web',
                'display_name'   => 'مشاهده لیست کاربران',
                'module'    => 'user',
            ],
            [
                'name'     => 'user create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن کاربر',
                'module'    => 'user',
            ],
            [
                'name'     => 'user update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش کاربر',
                'module'    => 'user',
            ],
            [
                'name'     => 'user delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف کاربر',
                'module'    => 'user',
            ],
            [
                'name'     => 'user setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات کاربران',
                'module'    => 'user',
            ],
            [
                'name'     => 'user assign role',
                'guard_name'    => 'web',
                'display_name'   => 'الصاق نقش به کاربر',
                'module'    => 'user',
            ],
            [
                'name'     => 'role assign permission',
                'guard_name'    => 'web',
                'display_name'   => 'الصاق دسترسی به نقش',
                'module'    => 'user',
            ],
            [
                'name'     => 'role manage',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت نقش',
                'module'    => 'user',
            ],
            [
                'name'     => 'role create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن نقش',
                'module'    => 'user',
            ],
            [
                'name'     => 'role update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش نقش',
                'module'    => 'user',
            ],
            [
                'name'     => 'role delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف نقش',
                'module'    => 'user',
            ],
            [
                'name'     => 'permission manage',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت مجوز های دسترسی',
                'module'    => 'user',
            ],
            [
                'name'     => 'permission create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن اجازه دسترسی',
                'module'    => 'user',
            ],
            [
                'name'     => 'permission update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش دسترسی کاربر',
                'module'    => 'user',
            ],
            [
                'name'     => 'permission delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف دسترسی',
                'module'    => 'user',
            ],
        ]);

        $permissions = Permission::where('module', 'user')->orWhere('module', '')->get();

        
        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insertOrIgnore([
                'role_id'   => Role::first()->id,
                'permission_id' => $permission->id
            ]);
        }
    }
}
