<?php

namespace Rezahmady\Chat;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Rezahmady\Chat\Http\Livewire\CreateMessage;
use Rezahmady\Chat\Http\Livewire\RoomListAudience;
use Rezahmady\Chat\Http\Livewire\RoomUserStatus;
use Rezahmady\Chat\View\Components\RoomListItem;
use Rezahmady\Chat\View\Components\Rooms;
use Rezahmady\Chat\View\Components\Room;
use Rezahmady\Chat\View\Components\Messages;
use Rezahmady\Chat\View\Components\Gallery;
use Rezahmady\Chat\View\Components\RoomSidebar;
use Rezahmady\Chat\View\Components\Suggestions;
use Rezahmady\Chat\View\Components\Archives;
use Livewire\Livewire;
use Rezahmady\Chat\Http\Livewire\Index;
use Rezahmady\Chat\Http\Middleware\RoomMiddleware;
use Rezahmady\Chat\Models\Chat;
use Rezahmady\Chat\Models\Room as ModelsRoom;
use Rezahmady\User\Models\User;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'chat';
    protected $commands = [];

    public function moduleBoot(): void
    {

        Livewire::component('chat.create-message', CreateMessage::class);
        Livewire::component('chat.room-list-audience', RoomListAudience::class);
        Livewire::component('chat.room-user-status', RoomUserStatus::class);
        Livewire::component('rezahmady.chat.http.livewire.index', Index::class);
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

    public function menuBuilder($menu)
    {
        if(backpack_user()->can('chat list')) {
            $menu->add('chats', trans('rezahmady.chat::chat.room_menu_label') , backpack_url('room') , 300, 'comments');
        }
    }
}
