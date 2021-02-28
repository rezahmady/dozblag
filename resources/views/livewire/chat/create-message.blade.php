<div class="chat-footer">
    <form x-ref="div" wire:submit.prevent="submit" x-data="{open_voic: false}"  id="ta-frame" style="position: relative;">
        <div id="voiceHolder" x-ref="voiceHolder" x-show="open_voic" >
            <button x-on:click="pauseRecording()" class="btn btn-floating" type="button">
                <i class="fa fa-pause voice-btn player-btn-pause"></i>
            </button>
            <button x-on:click="stopRecording()" class="btn btn-floating" type="button">
                <i class="fa fa-stop voice-btn player-btn-stop"></i>
            </button>
            
            <div class="wave-holder">
                <img class="player-gif-wave" src="{{asset('packages/chatino/media/img/sound.gif')}}">
            </div>
            <button class="btn btn-floating" x-on:click="deleteRecording();open_voic = false" type="button">
                <i class="fa fa-trash-o voice-btn player-btn-trash"></i>
            </button>
        </div>
        
        <textarea autofocus id="textarea" x-ref="ta" wire:keydown.enter.prevent="submit" x-on:keydown="autosize($refs.div,$refs.ta)" wire:model.defer="body" class="textarea" rows='1' placeholder="متن پیام..." x-text="content" ></textarea>

        <div class="form-buttons">
            <button class="btn btn-light btn-floating" type="button">
                <i class="fa fa-paperclip"></i>
            </button>
            <button id="recordButton" x-on:click="startRecording();open_voic = true" class="btn btn-light btn-floating" type="button">
                <i class="fa fa-microphone"></i>
            </button>
            <button class="btn btn-primary btn-floating" type="submit">
                <i class="fa fa-send"></i>
            </button>
        </div>
    </form>
    <script>
        // var div = document.querySelector('#ta-frame');
        // var ta =  document.querySelector('textarea');
    
        // ta.addEventListener('keydown', autosize);
    
        
        // document.addEventListener("DOMContentLoaded", () => {
        //     $(document).ready(function(){
        //         var $textarea = $('#textarea');
        //         $textarea.on('keyup', RTLText.onTextChange);
        //         $textarea.on('keydown', RTLText.onTextChange);
        //         RTLText.setText($textarea.get(0), $textarea.val());
        //     });
        // });
    </script>
</div>




