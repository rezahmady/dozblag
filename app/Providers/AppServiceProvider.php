<?php

namespace App\Providers;

use App\View\Components\Archives;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;
use App\View\Components\RoomListItem;
use App\View\Components\Rooms;
use App\View\Components\Room;
use App\View\Components\Messages;
use App\View\Components\Gallery;
use App\View\Components\RoomSidebar;
use App\View\Components\Suggestions;

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
        if ($this->app->isLocal()) $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
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

        Blade::component('chat-room-list-item', RoomListItem::class);
        Blade::component('chat-rooms', Rooms::class);
        Blade::component('chat-room', Room::class);
        Blade::component('chat-messages', Messages::class);
        Blade::component('chat-gallery', Gallery::class);
        Blade::component('chat-room-sidebar', RoomSidebar::class);
        Blade::component('chat-suggestions', Suggestions::class);
        Blade::component('chat-archives', Archives::class);

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
