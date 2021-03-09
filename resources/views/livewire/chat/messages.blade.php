<div class="chat-body" id="chat-body" > 
    <div class="messages" id="messages-holder" >
        @php
            $messages_grouped = [];
            foreach ($messages->reverse() as $message) {
            $messages_grouped[$message->date][] = $message;
            }
        @endphp
<style>
    .gallery-column {
        float: left;
        width: 25%;
    }

    /* The Modal (background) */
    .gallery-modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: black;
    }

    /* Modal Content */
    .modal-content {
    position: relative;
    background-color: black;
    margin: auto;
    padding: 0;
    width: 90%;
    max-width: 1200px;
    }

    /* The Close Button */
    .gallery-close {
    color: white;
    position: absolute;
    top: 10px;
    right: 25px;
    font-size: 35px;
    font-weight: bold;
    }

    .gallery-close:hover,
    .gallery-close:focus {
    color: #999;
    text-decoration: none;
    cursor: pointer;
    }

    .mySlides {
    display: none;
    }

    .cursor {
    cursor: pointer;
    }

    /* Next & previous buttons */
    .gallery-prev,
    .gallery-next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -50px;
    color: white;
    font-weight: bold;
    font-size: 20px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
    -webkit-user-select: none;
    }

    /* Position the "next button" to the right */
    .gallery-next {
    left: 0;
    border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .gallery-prev:hover,
    .gallery-next:hover {
    background-color: rgba(0, 0, 0, 0.8);
    }

    /* Number text (1/3 etc) */
    .numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
    }

    img {
    margin-bottom: -4px;
    }

    .caption-container {
    text-align: center;
    background-color: black;
    padding: 2px 16px;
    color: white;
    }

    .demo {
    opacity: 0.6;
    }

    .active,
    .demo:hover {
    opacity: 1;
    }

    img.hover-shadow {
    transition: 0.3s;
    }

    .hover-shadow:hover {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .mySlides img {
    width: auto;
    height: 75vh;
    margin: auto;
    display: block;
    }

    .gallery-thumb-holder {
        overflow: hidden;
        outline: currentcolor none medium;
        justify-content: center;
    }
</style>
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
                    <div class="message-content player" dir="ltr">
                        <audio src="{{url("/uploads/chat/voice/{$message->body}")}}"></audio>
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
                    <div class="message-content">
                        <div class="gallery-column-holder">
                            @foreach ($photos as $key => $photo)
                            <div class="gallery-column">
                              <img src="{{asset("/uploads/chat/photo/{$photo}")}}" style="width:100%" onclick="openModal();currentSlide({{$key+1}})" class="hover-shadow cursor">
                            </div>
                            @endforeach
                        </div>
                          
                        <div id="myModal" class="gallery-modal">
                            <span class="gallery-close cursor" onclick="closeModal()">&times;</span>
                            <div class="modal-content">
                                @foreach ($photos as $key => $photo)
                                    <div class="mySlides">
                                        <div class="numbertext">{{$key+1}} / {{$total}}</div>
                                        <img src="{{asset("/uploads/chat/photo/{$photo}")}}" >
                                    </div>
                                @endforeach
                            
                                <a class="gallery-prev" onclick="plusSlides(-1)">&#10094;</a>
                                <a class="gallery-next" onclick="plusSlides(1)">&#10095;</a>
                            
                                <div class="caption-container">
                                    <p id="caption"></p>
                                </div>
        
                                {{-- <div class="gallery-thumb-holder">
                                </div> --}}
                                
                                <div class="files">
                                    <ul class="list-inline gallery-thumb-holder" tabindex="1">
                                        @foreach ($photos as $key => $photo)
                                            <li class="list-inline-item">
                                                <a href="#">
                                                    <figure class="avatar avatar-lg">
                                                        <img class="demo cursor" src="{{asset("/uploads/chat/photo/{$photo}")}}" onclick="currentSlide({{$key+1}})">
                                                    </figure>
                                                </a>
                                            </li>
                                        @endforeach
                                        
                                    </ul>
                                </div>
                            
                            </div>
                        </div>
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