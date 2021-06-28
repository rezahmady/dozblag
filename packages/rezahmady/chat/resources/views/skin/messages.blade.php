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
                @if ($message->type == 'voice')
                <div class="message-item {{$class}}" id="message-{{$message->id}}">

                        <div class="" dir="ltr" style="width: 300px;">
                            <div 
                            {{-- data-source="{{url(config('rezahmady.chat.uploud_voice_path').$message->body)}}" --}}
                            id="mediPlayer_{{$message->id}}"
                                x-data
                            x-ref="voice_{{$message->id}}"
                            x-init="

                            new Calamansi(document.querySelector('#mediPlayer_{{$message->id}}'), {
                                skin: '/packages/chatino/js/vendor/calamansijs/skins/ayon',
                                playlists: {
                                    'Classics': [
                                        {
                                            source: '{{url(config('rezahmady.chat.uploud_voice_path').$message->body)}}',
                                        }
                                    ],
                                },
                                defaultAlbumCover: '{{$message->user->getProfile()}}',
                            });

                            $dispatch('scrollToBottom');
                            "
                            >
                                در حال پردازش پلیر ...
                            </div>
                        </div>

                    <div class="message-action">
                        {{$message->time}} {!! $seen !!}
                    </div>
                </div>
                @elseif ($message->type == 'photos')
                @php
                    $photos = json_decode($message->body);
                    $total = sizeOf($photos);
                @endphp
                
                <div class="message-item {{$class}}" id="message-{{$message->id}}">
                    <x-chat-gallery :photos="$photos" :id="$message->id" :class="'message-content'" />
                    <div class="message-action">
                        {{$message->time}} {!! $seen !!}
                    </div>
                </div>

                @else
                <div class="message-item {{$class}}" id="message-{{$message->id}}">
                    @if ($message->user_id != auth()->id() and backpack_user()->template != 'customer' )
                    <div class="message-sender">
                        {{$message->user->name}}
                    </div>
                    @endif
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

        {{-- <template x-if="messages" x-for="message in messages" :key="message.key" >
            <div class="message-item">
                <div class="message-content" x-text="message.text">
                </div>
                <div class="message-action">
                    <span x-text="message.time"></span> <i class="ti-time"></i>
                </div>
            </div>
        </template> --}}
        
    </div>
</div>
<script>
    Echo.channel('private-chat.{{$room->id}}')
    .listen('\\Rezahmady\\Chat\\Events\\MessageAdded', (e) => {
        window.Livewire.emit('prependMessageFromBroadcasting', e)
    }).listen('\\Rezahmady\\Chat\\Events\\MessageSeen', (e) => {
        window.Livewire.emit('refreshRooms')
    }).listen('\\Rezahmady\\Chat\\Events\\RoomStarted', (e) => {
        window.Livewire.emit('room-started')
    });

    Echo.channel('private-chat.{{$room->id}}.user.{{auth()->id()}}')
    .listen('\\Rezahmady\\Chat\\Events\\MessageSeenResponse', (e) => {
        window.Livewire.emit('refreshRooms')
    })
</script>