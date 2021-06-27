<div class="layout" id="app" x-data="data()"  x-init="init()">
    <!-- disconnected modal -->
    <div class="modal fade show" wire:offline id="disconnected" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="connection-error">
                        <h4 class="text-center">برنامه قطع شد...</h4>
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                            y="0px"
                            width="862.899px" height="862.9px" viewBox="0 0 862.899 862.9" style="enable-background:new 0 0 862.899 862.9;"
                            xml:space="preserve">
                            <g>
                                <g>
                                    <circle cx="385.6" cy="656.1" r="79.8"/>
                                    <path d="M561.7,401c-15.801-10.3-32.601-19.2-50.2-26.6c-39.9-16.9-82.3-25.5-126-25.5c-44.601,0-87.9,8.9-128.6,26.6
                                        c-39.3,17-74.3,41.3-104.1,72.2L253.5,545c34.899-36.1,81.8-56,132-56c49,0,95.1,19.1,129.8,53.8l25.4-25.399L493,469.7L561.7,401
                                        z"/>
                                    <path d="M385.6,267.1c107.601,0,208.9,41.7,285.3,117.4l98.5-99.5c-50-49.5-108.1-88.4-172.699-115.6
                                        c-66.9-28.1-138-42.4-211.101-42.4c-73.6,0-145,14.4-212.3,42.9c-65,27.5-123.3,66.8-173.3,116.9l99,99
                                        C175.5,309.299,277.3,267.1,385.6,267.1z"/>
                                    <polygon points="616.8,402.5 549.7,469.599 639.2,559.099 549.7,648.599 616.8,715.7 706.3,626.2 795.8,715.7 862.899,648.599
                                        773.399,559.099 862.899,469.599 795.8,402.5 706.3,492 		"/>
                                </g>
                            </g>
                            <g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                        </svg>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{route('chatyno.index')}}" type="button" class="btn btn-primary btn-lg">دوباره وصل کنید</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ disconnected modal -->
    <!-- navigation -->
    <nav class="navigation">
        <div class="nav-group">
            <ul>
                <li>
                    <a x-on:click.prevent="set_navigation('chats')" :class="{ 'active': navigation_target == 'chats' }" href="#">
                        <i class="ti-comment-alt"></i>
                    </a>
                </li>
                @if (backpack_user()->hasTemplate('operator'))
                <li class="chat-menu">
                    <a x-on:click.prevent="set_navigation('suggestion')" wire:click="resetUnseen()" :class="{ 'active': navigation_target == 'suggestion' }" href="#" >
                        @if ($unseenNewConsoltation)
                        <div class="users-list-action">
                            <div class="new-message-count">{{$unseenNewConsoltation}}</div>
                        </div>
                        @endif
                        <i class="ti-user"></i>
                    </a>
                </li>
                @endif
                @if (backpack_user()->hasTemplate(['operator', 'doctor']) )
                <li class="chat-menu">
                    <a x-on:click.prevent="set_navigation('archives')" :class="{ 'active': navigation_target == 'archives' }" href="#">
                        <i class="ti-archive"></i>
                    </a>
                </li>
                @endif
                {{-- <li>
                    <a href="#" data-toggle="modal" data-target="#editProfileModal">
                        <i class="ti-pencil"></i>
                    </a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#settingModal">
                        <i class="ti-settings"></i>
                    </a>
                </li> --}}
                <li class="lofout-button">
                    <a href="{{route('home')}}">
                        <i class="ti-power-off"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- ./ navigation -->

    <!-- content -->
    <div class="content">

        <!-- sidebar group -->
        <div class="sidebar-group menu" :class="{ 'active': sidebar === true }" >

            <!-- Chats sidebar -->
            <div x-show="navigation_target == 'chats'" :class="{ 'active': navigation_target == 'chats' }" class="sidebar">
                <header>
                    <span>گفت و  گو ها</span>
                </header>
                <form action="#">
                    <input type="text" class="form-control" placeholder="جستجوی چت">
                </form>
                <x-chat-rooms />
            </div>
            <!-- ./ Chats sidebar -->
            @if (backpack_user()->hasTemplate('operator'))
            <!-- Friends sidebar -->
            <div x-show="navigation_target == 'suggestion'" :class="{ 'active': navigation_target == 'suggestion' }" class="sidebar">
                <header>
                    <span>پذیرش نشده</span>
                </header>
                <form action="#">
                    <input type="text" class="form-control" placeholder="جستجوی چت">
                </form>
                <x-chat-suggestions />
            </div>
            <!-- ./ Friends sidebar -->
            @endif

            @if (backpack_user()->hasTemplate(['operator', 'doctor']) )
            <!-- Favorites sidebar -->
            <div x-show="navigation_target == 'archives'" :class="{ 'active': navigation_target == 'archives' }" class="sidebar">
                <header>
                    <span>آرشیو</span>
                </header>
                <form action="#">
                    <input type="text" class="form-control" placeholder="جستجو در آرشیو">
                </form>
                <x-chat-archives />
            </div>
            <!-- ./ Stars sidebar -->
            @endif
            
            <nav class="navigation">
                <div class="nav-group">
                    <ul>
                        <li>
                            <a x-on:click.prevent="set_navigation('chats')" :class="{ 'active': navigation_target == 'chats' }" href="#">
                                <i class="ti-comment-alt"></i>
                            </a>
                        </li>
                        @if (backpack_user()->hasTemplate('operator'))
                        <li class="chat-menu">
                            <a x-on:click.prevent="set_navigation('suggestion')" wire:click="resetUnseen()" :class="{ 'active': navigation_target == 'suggestion' }" href="#" >
                                @if ($unseenNewConsoltation)
                                <div class="users-list-action">
                                    <div class="new-message-count">{{$unseenNewConsoltation}}</div>
                                </div>
                                @endif
                                <i class="ti-user"></i>
                            </a>
                        </li>
                        @endif
                        @if (backpack_user()->hasTemplate(['operator', 'doctor']) )
                        <li>
                            <a x-on:click.prevent="set_navigation('archives')" :class="{ 'active': navigation_target == 'archives' }" href="#">
                                <i class="ti-archive"></i>
                            </a>
                        </li>
                        @endif
                        <li  class="lofout-button">
                            <a href="{{route('home')}}">
                                <i class="ti-power-off"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

        </div>
        <!-- ./ sidebar group -->

        <!-- chat -->
        <div class="chat position-relative" :class="{ 'active': sidebar === false }" >
            <x-chat-room :room="$currentRoom" :audience="$audience" :onlineUsers="$onlineUsers" />

            <div x-show="loadingRoom" class="loading-holder">
                <div class="container p-3 empty-chat-holder" >
                    <div  class="empty-chat-img loader-spiner-01"></div>
                </div>
            </div>
        </div>
        <!-- ./ chat -->
        <x-chat-room-sidebar :room="$currentRoom" :audience="$audience" />

    </div>
    <!-- ./ content -->

</div>

<script>

    function data() {
        return {
            sidebar: true,
            profile: false,
            loadingRoom: false,
            currentRoom: @entangle('currentRoom'),
            navigation_target: localStorage.getItem("navigation-target") ?? 'chats',
            set_navigation(target) {
                localStorage.setItem("navigation-target", target);
                this.navigation_target = target;
            },
            setRoom() {
                this.sidebar = false;
                this.loadingRoom = true;
            },
            hiddenLoader() {
                this.loadingRoom = false;
            },
            sidebarShow() {
                this.sidebar = true;
            },
            profileShow() {
                this.profile = true;
            },
            profileClose() {
                this.profile = false;
            },
            init() {
                this.hiddenLoader();
                if(this.currentRoom) {
                    this.sidebar = false;
                }
                window.addEventListener('room-set', event => {
                    this.loadingRoom = false;
                })
            },
        }
    }

    function starRating(){
        return {
            rating: 0,
            hoverRating: 0,
            ratings: [
                {'amount': 1, 'label':'بسیار بد'},
                {'amount': 2, 'label':'بد'},
                {'amount': 3, 'label':'متوسط'},
                {'amount': 4, 'label':'خوب'},
                {'amount': 5, 'label':'عالی'}
            ],
            rate(amount) {
                if (this.rating == amount) {
                    this.rating = 0;
                }
                else this.rating = amount;
            },
            currentLabel() {
                let r = this.rating;
                if (this.hoverRating != this.rating) r = this.hoverRating;
                let i = this.ratings.findIndex(e => e.amount == r);
                if (i >=0) {return this.ratings[i].label;} else {return ''};     
            }
        }
    }

    function timerCounterDown() {
        return {
            expiry: '',
            remaining:null,
            finish: false,
            init() {
                this.expiry = @this.expireDate;
                this.setRemaining()
                setInterval(() => {
                    this.setRemaining();
                }, 1000);

                window.addEventListener('room-set-time', event => {
                    this.expiry = event.detail.expire_date;
                })
            },
            setRemaining() {
                if(this.expiry) {
                    const diff = new Date(this.expiry) - new Date().getTime();
                    if(diff >= 0) {
                        this.remaining =  parseInt(diff / 1000);
                    }
                    if(diff < 0 && this.finish == false) {
                        Livewire.emit('room-end');
                        this.finish = true;
                    }
                }
            },
            days() {
                return {
                    value:this.remaining / 86400,
                    remaining:this.remaining % 86400
                };
            },
            hours() {
                return {
                    value:this.days().remaining / 3600,
                    remaining:this.days().remaining % 3600
                };
            },
            minutes() {
                return {
                    value:this.hours().remaining / 60,
                    remaining:this.hours().remaining % 60
                };
            },
            seconds() {
                return {
                    value:this.minutes().remaining,
                };
            },
            format(value) {
                return ("0" + parseInt(value)).slice(-2)
            },
            time(){
                return {
                    days:this.format(this.days().value),
                    hours:this.format(this.hours().value),
                    minutes:this.format(this.minutes().value),
                    seconds:this.format(this.seconds().value),
                }
            },
        }
    }

    function CreateMessage() {
        return {
            buttons_holder: false,
            content: '',
            open_buttons() {
                this.buttons_holder = true;
            },
            close_buttons() {
                this.buttons_holder = false;
            },
            toggle_buttons() {
                this.buttons_holder = ! this.buttons_holder;
            },
            rating: 0,
            hoverRating: 0,
            ratings: [{'amount': 1, 'label':'Terrible'}, {'amount': 2, 'label':'Bad'}, {'amount': 3, 'label':'Okay'}, {'amount': 4, 'label':'Good'}, {'amount': 5, 'label':'Great'}],
            rate(amount) {
                if (this.rating == amount) {
                    this.rating = 0;
                }
                else this.rating = amount;
            },
            currentLabel() {
                let r = this.rating;
                if (this.hoverRating != this.rating) r = this.hoverRating;
                let i = this.ratings.findIndex(e => e.amount == r);
                if (i >=0) {return this.ratings[i].label;} else {return ''};     
            }
        }
    }

    function VoiceRecorder() {
        return {
            voice_holder: false,
            isUploading: false,
            progress: 0,
            gumStream,
            rec,
            input,
            audioContext,
            URL,
            init() {
                this.URL = window.URL || window.webkitURL;
            },
            open_voice() {
                this.buttons_holder = false;
                this.voice_holder = true;
            },
            close_voice() {
                this.voice_holder = false;
            },
            startRecording() {
                console.log("recordButton clicked");
                /*
                    Simple constraints object, for more advanced audio features see
                    https://addpipe.com/blog/audio-constraints-getusermedia/
                */
               //webkitURL is deprecated but nevertheless
                

                // shim for AudioContext when it's not avb. 
                var AudioContext = window.AudioContext || window.webkitAudioContext;

                var constraints = { audio: true, video: false }

                /*
                    We're using the standard promise based getUserMedia() 
                    https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
                */
                navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
                    console.log("getUserMedia() success, stream created, initializing Recorder.js ...");
                    /*
                        create an audio context after getUserMedia is called
                        sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
                        the sampleRate defaults to the one set in your OS for your playback device

                    */
                    this.audioContext = new AudioContext();

                    /*  assign to gumStream for later use  */
                    this.gumStream = stream;
                    /* use the stream */
                    input = this.audioContext.createMediaStreamSource(stream);
                    /* 
                        Create the Recorder object and configure to record mono sound (1 channel)
                        Recording 2 channels  will double the file size
                    */
                    this.rec = new Recorder(input, { numChannels: 1 })
                    //start the recording process
                    this.rec.record()
                    console.log("Recording started");
                }).catch(function(err) {
                    //enable the record button if getUserMedia() fails
                    console.log(err);
                });
            },
            pauseRecording() {
                console.log("pauseButton clicked rec.recording=", rec.recording);
                if (this.rec.recording) {
                    //pause
                    this.rec.stop();
                    pauseButton.innerHTML = "Resume";
                } else {
                    //resume
                    this.rec.record()
                    pauseButton.innerHTML = "Pause";

                }
            },
            stopRecording() {
                console.log("stopButton clicked");

                //disable the stop button, enable the record too allow for new recordings
                // stopButton.disabled = true;
                // recordButton.disabled = false;
                // pauseButton.disabled = true;

                //reset button just in case the recording is stopped while paused
                // pauseButton.innerHTML = "Pause";

                //tell the recorder to stop the recording
                this.rec.stop();

                //stop microphone access
                this.gumStream.getAudioTracks()[0].stop();

                //create the wav blob and pass it on to createDownloadLink
                this.rec.exportWAV(this.createDownloadLink);
            },
            deleteRecording() {
                //tell the recorder to stop the recording
                this.rec.stop();

                //stop microphone access
                this.gumStream.getAudioTracks()[0].stop();
                var recordingsList = document.getElementById("voiceHolder");
                recordingsList.innerHTML = `
                    <button x-on:click="pauseRecording()" class="btn btn-floating" type="button">
                        <i class="fa fa-pause voice-btn player-btn-pause"></i>
                    </button>
                    <button x-on:click="stopRecording()" class="btn btn-floating" type="button">
                        <i class="fa fa-stop voice-btn player-btn-stop"></i>
                    </button>
                    
                    <div class="wave-holder" dir="ltr">
                        <img class="player-gif-wave" src="/packages/chatino/media/img/sound.gif">
                    </div>
                    <button class="btn btn-floating" x-on:click="deleteRecording();close_voice()" type="button">
                        <i class="fa fa-trash-o voice-btn player-btn-trash"></i>
                    </button>
                `;
            },
            createDownloadLink(blob) {
                var recordingsList = document.getElementById("voiceHolder");
                var url = this.URL.createObjectURL(blob);
                var au = document.createElement('audio');
                var holder = document.createElement('div');
                var link = document.createElement('a');
                var send = document.createElement('button');
                var trash = document.createElement('button');



                //name of .wav file to use during upload and download (without extendion)
                var filename = new Date().toISOString();

                //add controls to the <audio> element
                au.controls = true;
                au.style.display = 'none';
                au.style.margin = 'auto';
                au.src = url;

                // trash
                trash.setAttribute('class', 'btn btn-floating');
                trash.setAttribute('x-on:click', 'close_voice();deleteRecording();');
                trash.innerHTML = '<i class="fa fa-trash-o voice-btn player-btn-trash"></i>';



                //save to disk link
                link.setAttribute('class', 'btn btn-floating');
                link.href = url;
                link.download = filename + ".wav"; //download forces the browser to donwload the file using the  filename
                link.innerHTML = '<i class="fa fa-download voice-btn player-btn-stop"></i>';




                // holder
                holder.setAttribute('class', 'wave-holder');
                holder.appendChild(au);


                var formdata = new FormData();
                formdata.append('audio-blob', blob);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '/upload/voice',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(data) {

                        // button
                        send.setAttribute('class', 'btn btn-primary btn-floating');
                        send.setAttribute('x-on:click', `$wire.saveVoice('${data.filename}');close_voice()`);
                        send.innerHTML = '<i class="fa fa-send"></i>';


                        recordingsList.innerHTML = '';
                        recordingsList.appendChild(trash);
                        // recordingsList.appendChild(link);
                        recordingsList.appendChild(holder);
                        recordingsList.appendChild(send);
                        // window.dispatchEvent('playAudio');
                        // new GreenAudioPlayer('.wave-holder');
                        GreenAudioPlayer.init({
                            selector: '.wave-holder', // inits Green Audio Player on each audio container that has class "player"
                            stopOthersOnPlay: true,
                            // showDownloadButton: true
                        });
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        //error message 
                    }
                });
            }
        }
    }
    
    function autosize(div,ta) {
        setTimeout(function() {
            ta.style.cssText = 'height:0px';
            var height = Math.min(20 * 5, ta.scrollHeight);
            var height_holder = (height < 65) ? 65 : height;
            div.style.cssText = 'height:' + height_holder + 'px';
            ta.style.cssText = 'height:' + height + 'px';
        },0);
    }

    function Gallery() {
        return {
            modal: false,
            slideIndex: 1,
            openModal() {
                this.modal = true;
            },
            closeModal() {
                this.modal = false;
            },
            plusSlides(n,m) {
                this.showSlides(this.slideIndex += n,m);
            },
            currentSlide(n,m) {
                this.showSlides(this.slideIndex = n,m);
            },
            showSlides(n,m) {
                var i;
                var slides = document.getElementsByClassName(`mySlides${m}`);
                var dots = document.getElementsByClassName(`demo${m}`);
                if (n > slides.length) {this.slideIndex = 1}
                if (n < 1) {this.slideIndex = slides.length}
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[this.slideIndex-1].style.display = "block";
                dots[this.slideIndex-1].className += " active";
            }
        }
    }

    window.addEventListener('scrollTo', event => {
        // location.href = '#'+event.detail.hash;
        var chat_body = $('.layout .content .chat .chat-body');
        if (chat_body.length > 0) {
        
            chat_body.scrollTop(chat_body.get(0).scrollHeight, -1).niceScroll({
                cursorcolor: 'rgba(66, 66, 66, 0.20)',
                cursorwidth: "4px",
                cursorborder: '0px'
            });
        }
        // setTimeout(function() { document.getElementById("textarea").focus() }, 1000);
        // console.log('csrllTo');
    })

    window.addEventListener('scrollToBottom', event => {
        // location.href = '#'
        // var element = document.getElementById("messages-holder");
        // element.scrollIntoView({
        //     block: "end",
        //     behavior: "smooth"
        // });
        var chat_body = $('.layout .content .chat .chat-body');
        if (chat_body.length > 0) {        
            chat_body.scrollTop(chat_body.get(0).scrollHeight, -1).niceScroll({
                cursorcolor: 'rgba(66, 66, 66, 0.20)',
                cursorwidth: "4px",
                cursorborder: '0px'
            });
        }
        // if (document.getElementById("textarea")) {
        //     setTimeout(function() { document.getElementById("textarea").focus() }, 2000);
        // }
        // console.log('scrollToBottom');

    })

    document.addEventListener('DOMContentLoaded', function () {
        
        Livewire.hook('component.initialized', (component) => {
            $(document).on('lity:close', function(event, instance) {
                setTimeout(() => {
                    Livewire.emit('edited-rooms')
                }, 1000);
            }); 
        })
    
    })

</script>
