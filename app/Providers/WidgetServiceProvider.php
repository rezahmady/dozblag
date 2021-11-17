<?php

namespace App\Providers;

use App\Services\Widget\Widget;
use Illuminate\Support\ServiceProvider;
use TorMorten\Eventy\Facades\Eventy as Hook;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Widget',function(){
            return new Widget();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Hook::addFilter('admin-dashboard-widget::filter', function($widgets) {
            $widgets = \App\Services\Widget\Facades\Widget::fetch($widgets);
            return $widgets;
        }, 2000, 1);
    }
}
