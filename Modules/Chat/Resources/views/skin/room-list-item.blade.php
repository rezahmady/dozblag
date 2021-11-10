@if ($status === 'chat')
<li wire:click="setRoom({{$room->id}})" x-on:click="setRoom({{$room->id}})" class="list-group-item">
    <livewire:chat.room-list-audience :audience="$audience" :room="$room" :key="'figure-room-item'.$room->id" />
    <div class="users-list-body">
        <h5>{{$audience->name}}</h5>
        @if (auth()->user()->template === 'customer')
        <p style="color: #ffd97e">{{$rool}}</p>
        @elseif(auth()->user()->template === 'doctor')
        <p style="color: #ffd97e">{{$rool}}</p>
        @else 
        <p style="color: #ffd97e"><i class="fa fa-stethoscope"></i> {{$room->doctor->name}}</p>
        @endif

        @if ($message)
            @if ($message->type === 'voice')
                <p style="color: #2bd8f4"><i class="fa fa-microphone"></i> صدای ضبط شده </p>

            @elseif($message->type === 'photos')
                @php
                    $photos = json_decode($message->body);
                    $photo = $photos[0];
                @endphp
                <p style="color: #2bd8f4"><img style="width:20px;border-radius: 3px" src="{{url($photo)}}"> تصویر</p>
            
            @else
            <p style="color: #2bd8f4">{{$message->body}}</p>
            @endif
        @endif
        @if ($unread)
            <div class="users-list-action">
                <div class="new-message-count">{{$unread}}</div>
            </div>
        @endif
    </div>
</li>
@endif
