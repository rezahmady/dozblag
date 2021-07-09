<div class="sidebar-body position-relative">
    <ul class="list-group list-group-flush ">
        @foreach ($rooms as $room)
            <x-chat-room-list-item :room="$room" :key="'room-list-item-'.$room->id" />
        @endforeach
    </ul>
    <div wire:loading wire:target="searchChatTerm" class="loader-holder">
        <div  class="loader-spiner-01"></div>
    </div>
</div>