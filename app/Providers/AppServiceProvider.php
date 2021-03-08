<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;
use App\View\Components\RoomListItem;
use App\View\Components\Rooms;
use App\View\Components\Room;
use App\View\Components\Messages;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->overrideConfigValues();
    }

    protected function overrideConfigValues()
    {
        $config = [];
        if (config('settings.skin'))
            $config['backpack.base.skin'] = config('settings.skin');
        if (config('settings.show_powered_by'))
            $config['backpack.base.show_powered_by'] = config('settings.show_powered_by') == '1';
        config($config);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::component('room-list-item', RoomListItem::class);
        Blade::component('rooms', Rooms::class);
        Blade::component('room', Room::class);
        Blade::component('messages', Messages::class);
        
        Paginator::useBootstrap();

                /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
