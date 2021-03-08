<div class="sidebar-body">
    <ul class="list-group list-group-flush">
        @foreach ($rooms as $room)
            <x-room-list-item :room="$room" :key="'room-list-item-'.$room->id" />
        @endforeach
    </ul>
</div>