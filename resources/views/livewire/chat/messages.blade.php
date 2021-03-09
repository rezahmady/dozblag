<div class="chat-body" id="chat-body" > 
    <div class="messages" id="messages-holder" >
        @php
            $messages_grouped = [];
            foreach ($messages->reverse() as $message) {
            $messages_grouped[$message->date][] = $message;
            }
        @endphp

        @foreach ($messages_grouped as $date => $group)
        <p class="chat-date-tag">{{$date}}<p>
            @foreach ($group as $message)
                @php
                    $class = ($message->user_id == auth()->id()) ? '' : 'outgoing-message';
                    if($message->user_id == auth()->id()) {
                        $seen = ($message->seen) ? '<i class="ti-double-check"></i>' : '<i class="ti-check"></i>';
                    } else {
                        $seen = '';
                    }
                @endphp
                @if ($message->type == 'voice');
                <div class="message-item {{$class}}" id="message-{{$message->id}}">
                    <div class="message-content player" dir="ltr">
                        <audio src="{{url("/uploads/chat/voice/{$message->body}")}}"></audio>
                    </div>
                    <div class="message-action">
                        {{$message->time}} {!! $seen !!}
                    </div>
                </div>
                @else
                <div class="message-item {{$class}}" id="message-{{$message->id}}">
                    <div class="message-content">
                        {!! $message->body !!}
                    </div>
                    <div class="message-action">
                        {{$message->time}} {!! $seen !!}
                    </div>
                </div>
                @endif
                
            @endforeach
        @endforeach
        
    </div>
</div>
<script>
    // Your JS here.
    var element = document.getElementById("messages-holder");
    element.scrollIntoView({
        block: "end",
        behavior: "smooth"
    });


    Echo.channel('private-chat.{{$room->id}}')
    .listen('Chat\\MessageAdded', (e) => {
        window.Livewire.emit('prependMessageFromBroadcasting', e)
    }).listen('Chat\\MessageSeen', (e) => {
        window.Livewire.emit('refreshRooms')
    });

    Echo.channel('private-chat.{{$room->id}}.user.{{auth()->id()}}')
    .listen('Chat\\MessageSeenResponse', (e) => {
        window.Livewire.emit('refreshRooms')
    })
</script>