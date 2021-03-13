<div class="chat-footer" x-data="CreateMessage()">
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
            <div id="voiceHolder" x-ref="voiceHolder" x-show="voice_holder" >
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
            <form x-ref="div" wire:submit.prevent="submit"  id="ta-frame">
                
                <textarea autofocus id="textarea" x-ref="ta" wire:keydown.enter.prevent="submit" x-on:keydown="autosize($refs.div,$refs.ta)" wire:model.defer="body" class="textarea" rows='1' placeholder="متن پیام..." x-text="content" ></textarea>
        
                <div class="form-buttons p-relative">
                    <div class="buttons_holder" x-show="buttons_holder" x-on:click.away="close_buttons()">

                        <form wire:submit.prevent="savePhotos">
                            <button class="btn btn-light btn-floating mb-1 button-wrapper" type="submit">
                                <span class="label">
                                    <i class="fa fa-photo"></i>
                                </span>
                                <input type="file" wire:model="photos" multiple id="upload" class="upload-box" placeholder="">
                            </button>
                        </form>

                        <button x-on:click="startRecording();open_voice()" class="btn btn-light btn-floating mb-1" type="button">
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
        <form x-ref="div" wire:submit.prevent="cancelArchive()" style="justify-content: center">
            <button class="btn btn-primary " type="submit">
                خارج کردن از بایگانی
            </button>

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