<?php

namespace App\Providers;

use App\View\Widgets\MonthlyChart;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        Schema::defaultStringLength(191);

        $charts->register([
            \App\Charts\MonthlyChart::class
        ]);

        // Load helpers
        @include __DIR__.'/../Helpers/functions.php';

        Blade::component('core-widget-monthly-chart', MonthlyChart::class);

    }
}
