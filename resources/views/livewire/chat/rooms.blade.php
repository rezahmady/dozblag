<div class="sidebar-body">
    <ul class="list-group list-group-flush">
        @foreach ($rooms as $room)
            <x-chat-room-list-item :room="$room" :key="'room-list-item-'.$room->id" />
        @endforeach
    </ul>
</div>