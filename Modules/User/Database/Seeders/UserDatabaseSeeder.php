<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        DB::table('users')->delete();
        DB::table('users')->insert([
            'name'     => 'reza',
            'email'    => 'ahmadireza15@gmail.com',
            'password' => Hash::make('password'),
            'mobile'   => '09357000484',
        ]);


        DB::table('roles')->delete();
        DB::table('roles')->insert([
            'name'     => 'مدیر سیستم',
            'guard_name'    => 'web',
        ]);

        DB::table('model_has_roles')->delete();
        DB::table('model_has_roles')->insert([
            'role_id' => Role::where('name', 'مدیر سیستم')->first()->id,
            'model_type' => 'App\Models\User',
            'model_id' => User::first()->id,
        ]);

        DB::table('permissions')->delete();
        DB::table('permissions')->insert([
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
        ]);

        DB::table('role_has_permissions')->delete();
        $permissions = Permission::where('module', 'user')->orWhere('module', '')->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insert([
                'role_id'   => 1,
                'permission_id' => $permission->id
            ]);
        }
    }
}
