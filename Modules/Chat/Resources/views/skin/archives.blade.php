<div class="sidebar-body position-relative">
    <ul class="list-group list-group-flush users-list">
        @foreach ($rooms as $room)
        <li class="list-group-item" wire:click="setRoom({{$room->id}})" x-on:click="setRoom({{$room->id}})">
            <div>
                <figure class="avatar">
                    <img src="{{$room->user->getProfile()}}" class="rounded-circle">
                </figure>
            </div>
            <div class="users-list-body">
                <h5>{{$room->user->name}}</h5>
                <p>پزشک : {{$room->doctor->name}}</p>
            </div>
        </li>
        @endforeach
    </ul>
    <div wire:loading wire:target="searchArchiveTerm" class="loader-holder">
        <div  class="loader-spiner-01"></div>
    </div>
</div>