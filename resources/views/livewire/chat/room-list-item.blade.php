<li wire:click="setRoom({{$room->id}})" x-on:click="setRoom({{$room->id}})" class="list-group-item">
    <livewire:chat.room-list-audience :audience="$audience" :room="$room" :key="'figure-room-item'.$room->id" />
    <div class="users-list-body">
        <h5>{{$audience->name}}</h5>
        <p>{{$rool}}</p>
        @if ($unread)
            <div class="users-list-action">
                <div class="new-message-count">{{$unread}}</div>
            </div>
        @endif
    </div>
</li>

<script>
    Echo.channel('private-chat.{{$room->id}}')
    .listen('Chat\\MessageAdded', (e) => {
        console.log('private-chat.{{$room->id}}');
        Livewire.emit('refreshRooms')
    });

    
    // Echo.join('chat')
    //     .here((users) => {
    //         console.log(users);
    //         window.Livewire.emit('setUsersHere', users)
    //     })
    //     .joining((user) => {
    //         console.log(user.id,{{$audience->id}})
    //         console.log(this.status);
    //         window.Livewire.emit('setUserJoining', user)
    //     })
    //     .leaving((user) => {
    //         window.Livewire.emit('setUserLeaving', user)
    //     });

</script>
