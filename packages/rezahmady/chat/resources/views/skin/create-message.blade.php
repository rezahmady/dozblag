<div class="chat-footer" x-data="CreateMessage()"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false;"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = ($event.detail.progress == 100) ? 0 : $event.detail.progress; isUploading = ($event.detail.progress == 100) ? false : true">

    @if ($status === 'chat')
        @if ($photos)
            <div class="preview_holder">
                @foreach ($photos as $photo)
                <div>
                    <img src="{{ $photo->temporaryUrl() }}">
                </div>
                @endforeach
            </div>
        @endif
        <div class="p-relative">
            @if ($photos)
            <div class="form-wraper">
                <div class="form-buttons">
                    <button class="btn btn-floating" x-on:click="$wire.photos = null" type="button">
                        <i class="fa fa-trash-o voice-btn player-btn-trash"></i>
                    </button>
                    <button wire:click="savePhotos()" class="btn btn-primary btn-floating" type="submit">
                        <i class="fa fa-send"></i>
                    </button>
                </div>
            </div>
            @else
            <div x-data="VoiceRecorder()" >
                <div id="voiceHolder" x-ref="voiceHolder" x-show.transition="voice_holder" >
                    <button x-on:click="pauseRecording()" class="btn btn-floating" type="button">
                        <i class="fa fa-pause voice-btn player-btn-pause"></i>
                    </button>
                    <button x-on:click="stopRecording()" class="btn btn-floating" type="button">
                        <i class="fa fa-stop voice-btn player-btn-stop"></i>
                    </button>
                    
                    <div class="wave-holder" dir="ltr">
                        <img class="player-gif-wave" src="{{asset('packages/chatino/media/img/sound.gif')}}">
                    </div>
                    <button class="btn btn-floating" x-on:click="close_voice();deleteRecording();" type="button">
                        <i class="fa fa-trash-o voice-btn player-btn-trash"></i>
                    </button>
                </div>
            </div>
            <style>
                .w3-light-grey, .w3-hover-light-grey:hover, .w3-light-gray, .w3-hover-light-gray:hover {
                    color: #000!important;
                    background-color: #f1f1f1!important;
                }

                .w3-green, .w3-hover-green:hover {
                    color: #fff!important;
                    background-color: #4CAF50!important;
                }
            </style>
            
            <div x-show.transition="isUploading" class="w3-light-grey">
                <div class="w3-green" x-bind:style="`height:4px;width: ${progress}%`"></div>
            </div>
            <form x-ref="div" wire:submit.prevent="submit"  id="ta-frame">
                
                <textarea autofocus id="textarea" x-ref="ta" wire:keydown.enter.prevent="submit" x-on:keydown="autosize($refs.div,$refs.ta)" wire:model.defer="body" class="textarea" rows='1' placeholder="متن پیام..." x-text="content" ></textarea>
        
                <div class="form-buttons p-relative">
                    <div class="buttons_holder" x-show.transition="buttons_holder" x-on:click.away="close_buttons()" x-on:click="close_buttons()">

                        <form wire:submit.prevent="savePhotos">
                            <button class="mb-1 btn btn-light btn-floating button-wrapper" type="submit">
                                <span class="label">
                                    <i class="fa fa-photo"></i>
                                </span>
                                <input type="file" wire:model="photos" multiple id="upload" class="upload-box" placeholder="">
                            </button>
                        </form>

                        <button x-on:click="startRecording();open_voice()" class="mb-1 btn btn-light btn-floating" type="button">
                            <i class="fa fa-microphone"></i>
                        </button>
                        <button class="btn btn-light btn-floating" type="button" x-on:click="close_buttons()">
                            <i class="fa fa-angle-down"></i>
                        </button>
                    </div>
                    <button class="btn btn-light btn-floating" x-on:click="toggle_buttons()" type="button">
                        <i class="fa fa-angle-up"></i>
                    </button>
                    <button class="btn btn-primary btn-floating" type="submit">
                        <i class="fa fa-send"></i>
                    </button>
                </div>
            </form>
            @endif
        </div>
    @elseif($status === 'archive')
    <div class="p-relative">
        <div class="d-flex" style="padding:15px;justify-content: center">
            <button wire:click="cancelArchive()" class="btn btn-primary" type="submit">
                خارج کردن از بایگانی
            </button>
        </div>
    </div>
    @elseif($status === 'start') 
    <div class="p-relative">
        <form x-ref="div" wire:submit.prevent="startSuggestion" style="justify-content: center">
            <button class="btn btn-primary " type="submit">
                شروع گفت و گو
            </button>
        </form>
    </div>
    @elseif($status === 'end')
    <livewire:comment.create-comment :module="'User'" :moduleId="$room->doctor_id" :room="$room" :view="'theme::partials.comment.doctor-create-comment'" />
    <div class="p-relative">
        <form x-ref="div" style="justify-content: center">
            <span>پایان گفت و گو</span>
        </form>
    </div>
    @else
    <div class="p-relative">
        <form x-ref="div" wire:submit.prevent="acceptSuggestion" style="justify-content: center">
            <button class="btn btn-primary " type="submit">
                پذیرش گفت و گو
            </button>
        </form>
    </div>
    @endif

</div>
<script>
    window.addEventListener('playAudio', event => {
        GreenAudioPlayer.init({
            selector: '.player', // inits Green Audio Player on each audio container that has class "player"
            stopOthersOnPlay: true
        });
    })
</script>