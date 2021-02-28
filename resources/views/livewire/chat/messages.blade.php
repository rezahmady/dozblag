<div class="chat-body" id="chat-body"> 
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
                {{-- <livewire:chat.message :message="$message" /> --}}
                <div class="message-item {{$class}}" id="message-{{$message->id}}">
                    <div class="message-content">
                        {!! $message->body !!}
                    </div>
                    <div class="message-action">
                        {{$message->time}} {!! $seen !!}
                    </div>
                </div>
                
            @endforeach
        @endforeach
        
    </div>
    <script>
        // Your JS here.
        var element = document.getElementById("messages-holder");
        element.scrollIntoView(false);
    </script>
</div>