//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; //stream from getUserMedia()
var rec; //Recorder.js object
var input; //MediaStreamAudioSourceNode we'll be recording

// shim for AudioContext when it's not avb. 
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record

// var recordButton = document.getElementById("recordButton");
// var stopButton = document.getElementById("stopButton");
// var pauseButton = document.getElementById("pauseButton");

// //add events to those 2 buttons
// recordButton.addEventListener("click", startRecording);
// stopButton.addEventListener("click", stopRecording);
// pauseButton.addEventListener("click", pauseRecording);

function startRecording() {
    console.log("recordButton clicked");

    /*
    	Simple constraints object, for more advanced audio features see
    	https://addpipe.com/blog/audio-constraints-getusermedia/
    */

    var constraints = { audio: true, video: false }

    /*
    	Disable the record button until we get a success or fail from getUserMedia() 
	*/

    // recordButton.disabled = true;
    // stopButton.disabled = false;
    // pauseButton.disabled = false

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
        audioContext = new AudioContext();

        //update the format 
        // document.getElementById("formats").innerHTML = "Format: 1 channel pcm @ " + audioContext.sampleRate / 1000 + "kHz"

        /*  assign to gumStream for later use  */
        gumStream = stream;

        /* use the stream */
        input = audioContext.createMediaStreamSource(stream);

        /* 
        	Create the Recorder object and configure to record mono sound (1 channel)
        	Recording 2 channels  will double the file size
        */
        rec = new Recorder(input, { numChannels: 1 })

        //start the recording process
        rec.record()

        console.log("Recording started");

    }).catch(function(err) {
        //enable the record button if getUserMedia() fails

        console.log(err);
        // recordButton.disabled = false;
        // stopButton.disabled = true;
        // pauseButton.disabled = true
    });
}

function pauseRecording() {
    console.log("pauseButton clicked rec.recording=", rec.recording);
    if (rec.recording) {
        //pause
        rec.stop();
        pauseButton.innerHTML = "Resume";
    } else {
        //resume
        rec.record()
        pauseButton.innerHTML = "Pause";

    }
}

function stopRecording() {
    console.log("stopButton clicked");

    //disable the stop button, enable the record too allow for new recordings
    // stopButton.disabled = true;
    // recordButton.disabled = false;
    // pauseButton.disabled = true;

    //reset button just in case the recording is stopped while paused
    // pauseButton.innerHTML = "Pause";

    //tell the recorder to stop the recording
    rec.stop();

    //stop microphone access
    gumStream.getAudioTracks()[0].stop();

    //create the wav blob and pass it on to createDownloadLink
    rec.exportWAV(createDownloadLink);
}

function deleteRecording() {
    //tell the recorder to stop the recording
    rec.stop();

    //stop microphone access
    gumStream.getAudioTracks()[0].stop();
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
}



function createDownloadLink(blob) {
    var recordingsList = document.getElementById("voiceHolder");
    var url = URL.createObjectURL(blob);
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