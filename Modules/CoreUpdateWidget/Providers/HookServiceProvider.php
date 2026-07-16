<?php

namespace Modules\CoreUpdateWidget\Providers;

use Illuminate\Support\ServiceProvider;
use TorMorten\Eventy\Facades\Events as Hook;

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
         *  Admin widget
         */

        Hook::addFilter('admin-dashboard-widget::filter', function($widgets) {
            if(backpack_user()->can('coreUpdateWidget update')) {
                $widget = [
                    'id'  => 'core-update-widget',
                    'lg'  => 'col-lg-3',
                    'md'  => 'col-md-3',
                    'sm'  => 'col-sm-6',
                    'xsm' => 'col-12',
                    'view' => 'coreupdatewidget-widget-core-update',
                    'active' => true,
                ];
    
                array_push($widgets, $widget);
            }
            return $widgets;
        }, 20, 1);
    }
}
