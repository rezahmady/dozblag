<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\View\Widgets\UsersChart;
use TorMorten\Eventy\Facades\Eventy as Hook;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Hook::addFilter('admin-dashboard-widget::filter', function($widgets) {

            $widget = [
                'id'  => 'core-monthly-chart',
                'lg'  => 'col-lg-3',
                'md'  => 'col-md-3',
                'sm'  => 'col-sm-6',
                'xsm' => 'col-12',
                'view' => 'core-widget-monthly-chart',
                'active' => false,
            ];

            array_push($widgets, $widget);
            return $widgets;
        }, 20, 1);
    }
}
