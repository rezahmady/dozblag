<?php

namespace Modules\User\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use TorMorten\Eventy\Facades\Eventy as Hook;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /**
         *  Admin menu
         */
        Hook::addAction('admin-menu-build', function($menu) {
            if(backpack_user()->can('user manage')){

                $menu->add('users', ' مدیریت کاربران', '#' , 100 , 'users');
                $menu->add('users.user', trans('user::permissionmanager.users') , backpack_url('user') , 110, 'user');
                if(backpack_user()->can('role manage'))
                    $menu->add('users.role', trans('user::permissionmanager.roles') , backpack_url('role') , 120, 'id-badge');
                if(backpack_user()->can('permission manage'))
                    $menu->add('users.permission', trans('user::permissionmanager.permission_plural') , backpack_url('permission') , 130, 'key');
            }
        }, 5, 1);

        /**
         *  Admin widgets
         *
        */

        Hook::addFilter('admin-dashboard-widget::filter', function($widgets) {
            if(backpack_user()->can('user manage')) {
                $widget = [
                    'id'  => 'user-customers-number',
                    'lg'  => 'col-lg-3',
                    'md'  => 'col-md-3',
                    'sm'  => 'col-sm-6',
                    'xsm' => 'col-12',
                    'view' => 'user-widget-customers-number',
                    'active' => true,
                ];
    
                array_push($widgets, $widget);
            }
            return $widgets;
        }, 20, 1);

        /**
         *  Core Widget
         *  monthly chart
         */
        Hook::addAction('widget-core-monthly-chart::action', function($chart) {
            if(backpack_user()->can('user manage')) {
                $v = Verta();
                $data = [];
                for ($key=0 ; $key<12; $key++) {
                    $v = Verta();
                    $startMonth = (array) $v->month($key)->startMonth();
                    $endMonth = (array) $v->month($key)->endMonth();
    
                    $data['customers'][$key] = (int) User::where('template', 'customer')
                        ->whereBetween('created_at', [$startMonth['date'] , $endMonth['date']])->count();
                }
                $chart->dataset('کاربران', $data['customers']);
            }
        }, 20, 1);
    }

}
