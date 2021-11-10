<?php

namespace Modules\Chat\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Livewire\Livewire;
use Modules\User\Models\User;
use Modules\Chat\Http\Livewire\CreateMessage;
use Modules\Chat\Http\Livewire\RoomListAudience;
use Modules\Chat\Http\Livewire\RoomUserStatus;
use Modules\Chat\View\Components\RoomListItem;
use Modules\Chat\View\Components\Rooms;
use Modules\Chat\View\Components\Room;
use Modules\Chat\View\Components\Messages;
use Modules\Chat\View\Components\Gallery;
use Modules\Chat\View\Components\RoomSidebar;
use Modules\Chat\View\Components\Suggestions;
use Modules\Chat\View\Components\Archives;
use Modules\Chat\Http\Livewire\Index;
use Modules\Chat\Http\Middleware\RoomMiddleware;
use Modules\Chat\Models\Chat;
use Modules\Chat\Models\Room as ModelsRoom;
use TorMorten\Eventy\Facades\Eventy as Hook;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Chat';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'chat';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        Livewire::component('chat.create-message', CreateMessage::class);
        Livewire::component('chat.room-list-audience', RoomListAudience::class);
        Livewire::component('chat.room-user-status', RoomUserStatus::class);
        Livewire::component('chat.http.livewire.index', Index::class);
        Blade::component('chat-room-list-item', RoomListItem::class);
        Blade::component('chat-rooms', Rooms::class);
        Blade::component('chat-room', Room::class);
        Blade::component('chat-messages', Messages::class);
        Blade::component('chat-gallery', Gallery::class);
        Blade::component('chat-room-sidebar', RoomSidebar::class);
        Blade::component('chat-suggestions', Suggestions::class);
        Blade::component('chat-archives', Archives::class);

        // resolve model relations
        $this->resolveRelationUsing();
        $this->app['router']->aliasMiddleware('room', RoomMiddleware::class);

        Hook::addAction('admin-menu-build', function($menu) {
            if(backpack_user()->can('chat list')) {
                $menu->add('chats', trans('chat::chat.room_menu_label') , backpack_url('room') , 300, 'comments');
            }
        }, 20, 1);
    }

    public function resolveRelationUsing()
    {
        User::resolveRelationUsing('rooms', function ($Model) {
            return $Model->hasMany(ModelsRoom::class);
        });

        User::resolveRelationUsing('messages', function ($Model) {
            return $Model->hasMany(Chat::class);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
