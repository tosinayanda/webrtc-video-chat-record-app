<title>HTML5 WebPage Activity Recording using RecordRTC</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link rel="author" type="text/html" href="https://plus.google.com/+MuazKhan">
<meta name="author" content="Muaz Khan">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<style>
    body {
        overflow-x: hidden;
        background: rgb(233, 233, 233);
    }
    #elementToShare {
        background: rgb(233, 233, 233);
        font-size: 2em;
        height: 100%;
        left: 0;
        padding: 0 1em;
        position: absolute;
        top: 0;
        width: 100%;
    }
    input,
    textarea {
        border: 1px solid red;
        font-size: 1em;
        outline: none;
        padding: .3em .8em;
    }
    button,
    input[type=button] {
        -moz-border-radius: 3px;
        -moz-transition: none;
        -webkit-transition: none;
        background: #0370ea;
        background: -moz-linear-gradient(top, #008dfd 0, #0370ea 100%);
        background: -webkit-linear-gradient(top, #008dfd 0, #0370ea 100%);
        border: 1px solid #076bd2;
        border-radius: 3px;
        color: #fff;
        display: inline-block;
        font-family: inherit;
        font-size: .8em;
        font-size: 1.5em;
        line-height: 1.3;
        padding: 5px 12px;
        text-align: center;
        text-shadow: 1px 1px 1px #076bd2;
    }
    button:hover,
    input[type=button]:hover {
        background: rgb(9, 147, 240);
    }
    button:active,
    input[type=button]:active {
        background: rgb(10, 118, 190);
    }
    button[disabled],
    input[type=button][disabled] {
        background: none;
        border: 1px solid rgb(187, 181, 181);
        color: gray;
        text-shadow: none;
    }
    a {
        color: #2844FA;
        cursor: pointer;
        text-decoration: none;
    }
    a:hover,
    a:focus {
        color: #1B29A4;
    }
    a:active {
        color: #000;
    }
    img, textarea, input, video {
        vertical-align: top;
    }
    textarea {
        resize: verticalz;
    }
</style>

<div id="elementToShare" contenteditable style="margin-top: 3px;">
    <canvas id="animation" style="position:absolute;left:0;background-color:black; width: 300px;"></canvas>

    <video controls style="width:33%;position:absolute;right:40%; background-color:black;" src="video.webm" loop autoplay></video>
    <video id="camera" controls style="width:33%;position:absolute;right:100px; top:150px;background-color:black;"></video>
</div>

<div style="position: fixed;left: 20%;right: 20%;text-align: center;">
    <button id="start" contenteditable="false">Start Canvas Recording</button>
    <button id="stop" disabled contenteditable="false">Stop</button>
</div>

<script src="https://cdn.webrtc-experiment.com/screenshot.js"></script>
<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>

<script>
$( 'img' ).css('cursor', 'move').draggable().resizable();
$('video, h2, #other-demo-hints, #animation').css('cursor', 'move').draggable();
var elementToShare = document.getElementById('elementToShare');
var canvas2d = document.createElement('canvas');
var context = canvas2d.getContext('2d');
canvas2d.width = elementToShare.clientWidth;
canvas2d.height = elementToShare.clientHeight;
canvas2d.style.top = 0;
canvas2d.style.left = 0;
canvas2d.style.zIndex = -1;
(document.body || document.documentElement).appendChild(canvas2d);
var isRecordingStarted = false;
var isStoppedRecording = false;
(function looper() {
    if(!isRecordingStarted) {
        return setTimeout(looper, 500);
    }
    html2canvas(elementToShare, {
        grabMouse: true,
        onrendered: function(canvas) {
            context.clearRect(0, 0, canvas2d.width, canvas2d.height);
            context.drawImage(canvas, 0, 0, canvas2d.width, canvas2d.height);
            if(isStoppedRecording) {
                return;
            }
            setTimeout(looper, 1);
        }
    });
})();
var recorder = new RecordRTC(canvas2d, {
    type: 'canvas'
});
document.getElementById('start').onclick = function() {
    document.getElementById('start').disabled = true;
    isStoppedRecording = false;
    isRecordingStarted = true;
    playVideo(function() {
        recorder.startRecording();
        setTimeout(function() {
            document.getElementById('stop').disabled = false;
        }, 1000);
    });
};
function querySelectorAll(selector) {
    return Array.prototype.slice.call(document.querySelectorAll(selector));
}
document.getElementById('stop').onclick = function() {
    this.disabled = true;
    isStoppedRecording = true;
    recorder.stopRecording(function() {
        querySelectorAll('video').forEach(function(video) {
            video.pause();
            video.removeAttribute('src');
        });
        videoElement.stream.getTracks().forEach(function(track) {
            track.stop();
        });
        document.body.innerHTML = '';
        document.body.style = 'margin: 0; padding: 0;background: black; text-align: center; overflow: hidden;';
        var blob = recorder.getBlob();
        var video = document.createElement('video');
        video.src = URL.createObjectURL(blob);
        video.setAttribute('style', 'height: 100%;');
        document.body.appendChild(video);
        video.controls = true;
        video.play();
    });
};
window.onbeforeunload = function() {
    document.getElementById('start').disabled = false;
    document.getElementById('stop').disabled = true;
};
var videoElement = document.querySelector('#camera');
function playVideo(callback) {
    function successCallback(stream) {
        videoElement.stream = stream;
        videoElement.onloadedmetadata = function() {
            callback();
        };
        setSrcObject(stream, videoElement);
        videoElement.play();
    }
    function errorCallback(error) {
        console.error('get-user-media error', error);
        callback();
    }
    var mediaConstraints = { video: true };
    navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
}
// canvas animation
(function() {
    if(!innerWidth) var innerWidth = document.body.clientWidth;
    if(!innerHeight) var innerHeight = document.body.clientHeight;
    innerHeight = innerHeight - (innerHeight / 3);
    document.createElement("canvas").getContext?(function(){function a(){s.closePath(),s.fillStyle="rgba("+parseInt(Math.random()*255)+", "+parseInt(Math.random()*255)+", "+parseInt(Math.random()*255)+", .9)",s.fill(),s.beginPath()}function l(){var v;c+=5,h===1&&(t+=5,o+=5,n+=5,u+=5,c>20&&(h=2)),h===2&&(t-=5,o-=5,n-=5,u-=5,c>40&&(h=3)),h===3&&(f+=5,r+=5,i+=5,e+=5,c>60&&(h=4)),h===4&&(f-=5,r-=5,i-=5,e-=5,c>80&&(c=0,h=1)),s.clearRect(0,0,5e4,5e4);var y=[[t,n],[t,n],[t+269,n+69],[t+269,n+69],[t+211,n-162],[t+211,n-162],[t+23,n-213],[t+23,n-213],[t-165,n-60],[t-165,n-60],[t-72,n+116],[t-72,n+116],[t+74,n+117],[t+74,n+117],[t+128,n+128],[t+128,n+128],[t+274,n+15],[t+274,n+15],[t+137,n-158],[t+137,n-158],[t-80,n-97],[t-80,n-97],[t-114,n-10],[t-114,n-10],[t-165,n-57],[t-165,n-57],[t-72,n+118],[t-72,n+118],[t+72,n+117],[t+72,n+117],[t+268,n+67],[t+268,n+67],[t+211,n-162],[t+211,n-162],[t+24,n-211],[t+24,n-211]],p=[[f,i,r,e,o,u],[f+95,i+139,r-46,e+104,o,u],[f+186,i+153,r-44,e+97,o+29,u+3],[f+326,i+112,r+24,e+55,o+29,u+3],[f+317,i+12,r-7,e+77,o+5,u-65],[f+262,i-64,r-58,e-55,o+5,u-65],[f+154,i-43,r-116,e+6,o-88,u-76],[f+72,i-84,r-187,e-35,o-88,u-76],[f-81,i+111,r-162,e+70,o-142,u-39],[f-51,i+31,r-195,e-15,o-142,u-39],[f+78,i+239,r-123,e+142,o-124,u+47],[f-9,i+207,r-250,e+109,o-124,u+47],[f+107,i+229,r-162,e+130,o-55,u+61],[f+206,i+213,r-81,e+127,o-55,u+61],[f+196,i+191,r+67,e+166,o+151,u+108],[f+250,i+283,r+110,e+204,o+151,u+108],[f+283,i+100,r+87,e+12,o+136,u-78],[f+409,i+38,r+137,e-10,o+136,u-78],[f+164,i-44,r-76,e-50,o-36,u-163],[f+204,i-101,r-53,e-107,o-36,u-163],[f+23,i-2,r-156,e-53,o-118,u-132],[f-43,i-51,r-162,e-77,o-118,u-132],[f-26,i+101,r-190,e+86,o-189,u+73],[f-65,i+121,r-264,e+117,o-189,u+73],[f-65,i+121,r-264,e+117,o-363,u-30],[f-55,i+5,r-326,e-61,o-363,u-30],[f-61,i+140,r-261,e+205,o-239,u+204],[f+101,i+266,r-208,e+249,o-239,u+204],[f+110,i+237,r-161,e+190,o-22,u+238],[f+110,i+237,r+47,e+161,o-22,u+238],[f+309,i+214,r+121,e+202,o+254,u+160],[f+309,i+214,r+192,e+61,o+254,u+160],[f+325,i+14,r+161,e-98,o+178,u-203],[f+239,i-124,r+116,e-130,o+178,u-203],[f+179,i-105,r-74,e-175,o-104,u-255],[f+13,i-51,r-152,e-169,o-104,u-255]],w=36;for(v=0;v<w;v++)s.moveTo(y[v][0],y[v][1]),s.bezierCurveTo(p[v][0],p[v][1],p[v][2],p[v][3],p[v][4],p[v][5]),s.translate(y[v][0],y[v][1]),s.rotate(.001),s.translate(-y[v][0],-y[v][1]),a();oninterval(l)}var s;window.oninterval=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(n){window.setTimeout(n,1e3/60)}}(),s=document.getElementById("animation").getContext("2d"),s.canvas.width=innerWidth,s.canvas.height=innerHeight,s.lineWidth=2;var c=0,h=1,t=396,n=342,f=339,i=232,r=529,e=255,o=498,u=322;l()})():(alert("Your browser is not supporting HTML5 Canvas APIs!"))
})();
</script>

<a href="https://www.webrtc-experiment.com/RecordRTC/Canvas-Recording/" style="border-bottom: 1px solid red; color: red; font-size: 1.2em; position: absolute; right: 0; text-decoration: none; top: 0;">Other Canvas-Recording Demos</a>