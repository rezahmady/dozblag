<li wire:click="selectRoom({{$room->id}})" x-on:click="setRoom({{$room->id}})" class="list-group-item">
    <figure class="avatar">
        <img src="{{$audience->profile}}" class="rounded-circle">
    </figure>
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
