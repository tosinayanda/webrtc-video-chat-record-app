<!DOCTYPE html>
<html lang="en">

<head>
    <title>RecordRTC Audio+Video Recording & Uploading to PHP Server</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="author" type="text/html" href="https://plus.google.com/+MuazKhan">
    <meta name="author" content="Muaz Khan">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <link rel="stylesheet" href="https://cdn.webrtc-experiment.com/style.css">
    <script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
    <script src="https://cdn.webrtc-experiment.com/gif-recorder.js"></script>
    <script src="https://cdn.webrtc-experiment.com/getScreenId.js"></script>

    <!-- for Edige/FF/Chrome/Opera/etc. getUserMedia support -->
    <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
</head>
<body>
<script>
        // This example uses MediaRecorder to record from an audio and video stream, and uses the
// resulting blob as a source for a video element.
//
// The relevant functions in use are:
//
// navigator.mediaDevices.getUserMedia -> to get the video & audio stream from user
// MediaRecorder (constructor) -> create MediaRecorder instance for a stream
// MediaRecorder.ondataavailable -> event to listen to when the recording is ready
// MediaRecorder.start -> start recording
// MediaRecorder.stop -> stop recording (this will generate a blob of data)
// URL.createObjectURL -> to create a URL from a blob, which we use as video src

// var recordButton, stopButton, recorder, liveStream;

// window.onloads = function () {
//   recordButton = document.getElementById('record');
//   stopButton = document.getElementById('stop');

//   // get video & audio stream from user
//   navigator.mediaDevices.getUserMedia({
//     audio: true,
//     video: true
//   })
//   .then(function (stream) {
//     liveStream = stream;

//     var liveVideo = document.getElementById('live');
//     liveVideo.src = URL.createObjectURL(stream);
//     liveVideo.play();

//     recordButton.disabled = false;
//     recordButton.addEventListener('click', startRecording);
//     stopButton.addEventListener('click', stopRecording);

//   });
// };

// function startRecording() {
//   recorder = new MediaRecorder(liveStream);

//   recorder.addEventListener('dataavailable', onRecordingReady);

//   recordButton.disabled = true;
//   stopButton.disabled = false;

//   recorder.start();
// }

// function stopRecording() {
//   recordButton.disabled = false;
//   stopButton.disabled = true;

//   // Stopping the recorder will eventually trigger the 'dataavailable' event and we can complete the recording process
//   recorder.stop();
// }

// function onRecordingReady(e) {
//   var video = document.getElementById('recording');
//   // e.data contains a blob representing the recording
//   video.src = URL.createObjectURL(e.data);
//   video.play();
// }

var videoStream = new MediaStream();
var audioStream = new MediaStream();
var recorder =null;
var recorder2 =null;
navigator.mediaDevices.getUserMedia({
    audio: true,
    video: true
}).then(function(inputStream){

        // recorder = RecordRTC(inputStream, {
        //     type: 'video', // audio or video or gif or canvas
        //     recorderType: MediaStreamRecorder || CanvasRecorder || StereoAudioRecorder || Etc
        // });

        recorder = RecordRTC(inputStream, {
                mimeType: 'video/webm',
                bitsPerSecond: 128000
        });
       
        // Initialize the recorder
        recorder2 = new RecordRTCPromisesHandler(inputStream, {
                mimeType: 'video/webm',
                bitsPerSecond: 128000
        });

        recorder.startRecording();

        // Start recording the video
        recorder2.startRecording().then(function() {
                console.info('Recording video ...');
            }).catch(function(error) {
                console.error('Cannot start video recording: ', error);
            });
            // release stream on stopRecording
            recorder.stream = inputStream;

        var videoTracks = inputStream.getVideoTracks();
        videoTracks.forEach(function(track) {
            videoStream.addTrack(track);
        });

    var audioTracks = inputStream.getAudioTracks();
    audioTracks.forEach(function(track) {
        audioStream.addTrack(track);
    });

        setTimeout(() => {
        //console.log(" Yo");
            var video = document.getElementById('recording');

            recorder.stopRecording(function() {
                var blob = this.blob;

                // below one is recommended
                var blob = this.getBlob();

                 video.src = URL.createObjectURL(blob);
                // video.play();
                 video.load();
                UploadData(blob);
                 // Unmute video on preview
                video.muted = false;
                 //Upload Content                

                // Stop the device streaming
                this.stream.stop();
            });
           // recorder=recorder2;

            recorder2.stopRecording().then(function() {
            console.info('stopRecording success');

            // Retrieve recorded video as blob and display in the preview element
            var videoBlob = recorder2.getBlob();
            video.src = URL.createObjectURL(videoBlob);
            video.load();

            // Unmute video on preview
            video.muted = false;

            // Stop the device streaming
            this.stream.stop();
            
            })
            .catch(function(error) {
                console.error('stopRecording failure', error);
             });
            
        }, 5000);
    });
    function UploadData(blob)
    {
    // Create an instance of FormData and append the video parameter that
                // will be interpreted in the server as a file
               // var blob = recorder instanceof Blob ? recorder : recorder.blob;
               var fileType = blob.type.split('/')[0] || 'audio';
                var fileName = (Math.random() * 1000).toString().replace('.', '');

                if (fileType === 'audio') {
                    fileName += '.' + (!!navigator.mozGetUserMedia ? 'ogg' : 'wav');
                } else {
                    fileName += '.webm';
                }

                // create FormData
                var formData = new FormData();
                formData.append(fileType + '-filename', fileName);
                formData.append(fileType + '-blob', blob);

                // var formData = new FormData();
                // formData.append('video', player.recordedData.video);
                
                // Execute the ajax request, in this case we have a very simple PHP script
                // that accepts and save the uploaded "video" file
                xhr('save.php', formData, function (fName) {
                    console.log("Video succesfully uploaded !");
                });

                // Helper function to send 
                function xhr(url, data, callback) {
                    var request = new XMLHttpRequest();
                    request.onreadystatechange = function () {
                        if (request.readyState == 4 && request.status == 200) {
                            callback(location.href + request.responseText);
                        }
                    };
                    request.open('POST', url);
                    request.send(data);
                };
}
// Manipulate videoStream into a canvas, as shown above
// [...]
// Then get result from canvas stream into videoOutputStream
//var videoOutputStream = videoCanvas.captureStream();

// Manipulate audio with an audio context, as shown above
// [...]
// Then get result from audio destination node into audioOutputStream
// var audioOutputStream = streamDestination.stream;
// var outputStream = new MediaStream();
// [audioOutputStream, videoOutputStream].forEach(function(s) {
//     s.getTracks().forEach(function(t) {
//         outputStream.addTrack(t);
//     });
// });
// var finalRecorder = new MediaRecorder(outputStream);

</script>
<button id="record">Start Record</button>
<button id="stop"> Stop Record</button>
<video id="recording" preload="none" controls muted></video>
<video id="live" controls muted></video>


</body>