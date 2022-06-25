<?php

namespace Modules\ThemeManager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\User\Models\Permission;
use Kdabrow\SeederOnce\SeederOnce;

class ThemeManagerDatabaseSeeder extends Seeder
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
                'name'     => 'theme manage',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت پوسته‌ها',
                'module'    => 'theme',
            ],
            [
                'name'     => 'theme list',
                'guard_name'    => 'web',
                'display_name'   => 'مشاهده لیست پوسته‌ها',
                'module'    => 'theme',
            ],
            [
                'name'     => 'theme update',
                'guard_name'    => 'web',
                'display_name'   => 'انتخاب پوسته',
                'module'    => 'theme',
            ],
            [
                'name'     => 'theme delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف پوسته',
                'module'    => 'theme',
            ],
            [
                'name'     => 'theme setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات پوسته',
                'module'    => 'theme',
            ],
            [
                'name'     => 'widget manage',
                'guard_name'    => 'web',
                'display_name'   => 'مدیریت ابزارک‌ها',
                'module'    => 'theme',
            ],
            [
                'name'     => 'widget list',
                'guard_name'    => 'web',
                'display_name'   => 'مشاهده لیست ابزارک‌ها',
                'module'    => 'theme',
            ],
            [
                'name'     => 'widget create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن ابزارک',
                'module'    => 'theme',
            ],
            [
                'name'     => 'widget update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش ابزارک',
                'module'    => 'theme',
            ],
            [
                'name'     => 'widget delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف ابزارک',
                'module'    => 'theme',
            ],
            [
                'name'     => 'widget setting',
                'guard_name'    => 'web',
                'display_name'   => 'تنظیمات ابزارک',
                'module'    => 'theme',
            ],
            [
                'name'     => 'widget clone',
                'guard_name'    => 'web',
                'display_name'   => 'کپی کردن ابزارک',
                'module'    => 'theme',
            ],
        ]);

        $permissions = Permission::where('module', 'theme')->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insertOrIgnore([
                'role_id'   => User::first()->id,
                'permission_id' => $permission->id
            ]);
        }
    }
}
