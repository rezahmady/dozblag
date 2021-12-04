<?php

namespace Modules\Filter\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class FilterDatabaseSeeder extends Seeder
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
        DB::table('permissions')->insert([
            [
                'name'     => 'filter list',
                'guard_name'    => 'web',
                'display_name'   => 'مشاهده لیست فیلترها',
                'module'    => 'filter',
            ],
            [
                'name'     => 'filter create',
                'guard_name'    => 'web',
                'display_name'   => 'افزودن فیلتر',
                'module'    => 'filter',
            ],
            [
                'name'     => 'filter update',
                'guard_name'    => 'web',
                'display_name'   => 'ویرایش فیلتر',
                'module'    => 'filter',
            ],
            [
                'name'     => 'filter delete',
                'guard_name'    => 'web',
                'display_name'   => 'حذف فیلتر',
                'module'    => 'filter',
            ],
        ]);

        $permissions = Permission::where('module', 'filter')->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insert([
                'role_id'   => Role::where('name', 'مدیر سیستم')->first()->id,
                'permission_id' => $permission->id
            ]);
        }
    }
}
