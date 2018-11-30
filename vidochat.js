$(function() {
    /** Constants* */

    var servers = {
        iceServers: [
            {urls: 'stun:stun.l.google.com:19302'}
        ]
    };

    var myPC;
    var awaitingResponse;
    var streamConstraints;
    var myMediaStream;
    var connection;
    var currentuser;
    var connectedtouser;
    var isuseradmin;
    var allrooms=[];
    var allmessages=[];
    var room={id:"",user1:"",user2:"",conversationid:""};
    var videolinkpress=false;
    var emaillinkpress=false;
    var voicemutelinkpress=false;
    var voicecalllinkpress=false;
    var recorder =null;
    var remoterecorder =null;
    var audiorecorder1 =null;
    var audiorecorder2 =null;

      $("#spinners-home-overlay").hide();

     // console.log("User is ");
     // console.log("User is "+ currentsessionuser);

      console.log( "ready!" );   
     if(currentsessionuser)
     {
         user=currentsessionuser;
         currentuser=user;
     }
      $("#login").on("click",function(){
          if(user!=$("#user").val())
          {
            user=$("#user").val();
            currentuser=user;
          }

          connection.send(JSON.stringify({
            action: 'subscribe',
            user: user
            }));
          console.log("Logged in as "+ user);
          $(this).attr("disabled",true);
          $("#user").attr("disabled",true);
          $("#loginmodal").hide();

      });
      // if user is running mozilla then use it's built-in WebSocket
      window.WebSocket = window.WebSocket || window.MozWebSocket;

      // connection = new WebSocket('ws://192.168.2.21:8080/comm');
      connection = new WebSocket('ws://localhost:8080/comm');

      connection.onopen = function () {
        // connection is opened and ready to use

        console.log('connection Open');
        if(currentsessionuser)
        {
            user=currentsessionuser;
            currentuser=user;
              connection.send(JSON.stringify({
              action: 'subscribe',
              user: user
              }));
            console.log("Logged in as "+ user);
        }
      };

      connection.onclose=function()
      {

      };

      connection.onerror = function (error) {
        // an error occurred when sending/receiving data
        console.log('Error');
      };

      connection.onmessage = function (message) {

        var data = JSON.parse(message.data);
        console.log(data);
        ResolveMessage(data);
      };

       $(".messages").animate({ scrollTop: $(document).height() }, "fast");

        /** Event Listeners and Event Handlers* */

       $("#profile-img").click(function() {
         $("#status-options").toggleClass("active");
       });

       $(".expand-button").click(function() {
         $("#profile").toggleClass("expanded");
         $("#contacts").toggleClass("expanded");
       });

       $(".contact").click(function(e)
       {
            //console.log(e.timeStamp);
       });
       $(document).off("dblclick","#contacts li").on("dblclick","#contacts li",function(e){
         // alert("Clicked");
          //  console.log(e.timeStamp);
          if(connectedtouser!==$(this).attr("id"))
          {
            $("#contacts li").each(function(index)
            {
                if ($(this).hasClass("active"))
                {
                    $(this).removeClass("active");
                }
            });

            $(this).addClass("active");
            console.log("Current connected to "+$(this).attr("id"));
            $(".contact-profile img").attr("src",$(this).find("img").attr("src"));
            connectedtouser=$(this).attr("id");
            connectedusername=$(this).find("p").html();

            room=getChatRoom(currentuser,connectedtouser);
           // console.log(room);
            $("#connected-to").html(connectedusername);
            $(".messages ul").html("");
            GetChatHistory();
           return false;
         }
       });
       $("#video-link").on("dblclick",function(e){

         if(!videolinkpress)
         {
            console.log("Video");
           videolinkpress=!videolinkpress;
           InitializeCall("video");
           $("#video-link").attr("disabled",true);
           return false;
         }

       });
       $("#email-link").click(function(){

         if(!emaillinkpress)
         {
            emaillinkpress=!emaillinkpress;
            console.log("Email");
            //SendEmailToOutlook()
            return false;
         }

       });
       $("#voice-call-link").click(function(e){

         if(!voicecalllinkpress)
         {
            voicecalllinkpress=!voicecalllinkpress;
            console.log("Voice Call");
            InitializeCall("voice");
           return false;
         }

       });
       $("#status-options ul li").click(function() {
           $("#profile-img").removeClass();
           $("#status-online").removeClass("active");
           $("#status-away").removeClass("active");
           $("#status-busy").removeClass("active");
           $("#status-offline").removeClass("active");
           $(this).addClass("active");

           if($("#status-online").hasClass("active")) {
             $("#profile-img").addClass("online");
           } else if ($("#status-away").hasClass("active")) {
             $("#profile-img").addClass("away");
           } else if ($("#status-busy").hasClass("active")) {
             $("#profile-img").addClass("busy");
           } else if ($("#status-offline").hasClass("active")) {
             $("#profile-img").addClass("offline");
           } else {
             $("#profile-img").removeClass();
           };

           $("#status-options").removeClass("active");
       });

       $(document).off('keyup',".message-input input").on('keyup',".message-input input", function(e){
          e.preventDefault();
         // console.log(e.timeStamp);
          var msg = this.value.trim();

        //if user is typing
        if(msg){
            console.log("typing .....");
            connection.send(JSON.stringify({
                action: 'typingStatus',
                user: user,
                status: true,
                room: room
            }));
        }

        //if no text in input
        else{
            connection.send(JSON.stringify({
                action: 'typingStatus',
                user: user,
                status: false,
                room: room
            }));
        }

        });

        document.getElementById('submit').addEventListener("click",function(e) {
          console.log("Submitted");
          $("#submit").attr("disabled",true);
          newMessage();
        });

        $(window).on('keydown', function(e) {
            if (e.which == 13) {
                console.log("Submitted2");
                $("#submit").attr("disabled",false);
                newMessage();
                return false;
            }
        });

        $(document).off("dblclick",".answerCall").on("dblclick",".answerCall",answerCall);

        $(document).off("dblclick","#terminateCall").on("dblclick","#terminateCall",function(){
            console.log("doing Something");

            EndVideoCall("Call ended due to lack of response", true);

            // setTimeout(function(){
            //     $("#spinners-home-overlay").hide(1000);
            //     document.getElementById("rcivModal").style.display = 'none';
            // }, 3000);

            document.getElementById('callerTone').pause();
        });

        $(document).off("dblclick","#recordCall").on("dblclick","#recordCall",function(){
            console.log("doing Something");

    
        });

        $(document).off("dblclick","#endCallRecording").on("dblclick","#endCallRecording",function(){
            console.log("doing Something");

            var fileName = (Math.random() * 1000).toString().replace('.', '');

            if(recorder)
            {
                recorder.stopRecording(function() {
                    var blob = this.blob;
    
                    // below one is recommended
                    var blob = this.getBlob();

                    SaveCallRecording(blob,"local",fileName);

                });
            }
            if(remoterecorder)
            {
                remoterecorder.stopRecording(function() {
                    var blob = this.blob;
    
                    // below one is recommended
                    var blob = this.getBlob();

                    SaveCallRecording(blob,"remote",fileName);
                });
            }
            
            //stop tone
            document.getElementById('callerTone').pause();
        });
        /** Functions* */
        function ResolveMessage(data)
        {
            switch(data.action)
            {
              case 'initCall':

                $("#spinners-home-overlay").show(1000);
                document.getElementById('calleeInfo').style.color = 'black';
                document.getElementById('calleeInfo').innerHTML = data.msg;

                document.getElementById("rcivModal").style.display = 'block';

                document.getElementById('callerTone').play();
              break;

              case 'startCall':
                    //$("#spinners-home-overlay").show(1000);
                    startCall(false);//to start call when callee gives the go ahead (i.e. answers call)

                    document.getElementById("callModal").style.display = 'none';//hide call modal

                    clearTimeout(awaitingResponse);//clear timeout

                    //stop tone
                    document.getElementById('callerTone').pause();
              break;

              case 'endCall':

                    document.getElementById("calleeInfo").style.color = 'red';
                    document.getElementById("calleeInfo").innerHTML = data.msg;

                    setTimeout(function(){
                        $("#spinners-home-overlay").hide(1000);
                        document.getElementById("rcivModal").style.display = 'none';
                    }, 3000);

                    //stop tone
                    document.getElementById('callerTone').pause();

              break;

              case 'acceptCall':

              break;

              case 'rejectCall':

              break;

              case 'upgradeCall':

              break;

              case 'imOnline':
                console.log(data.user +" Is Online");
              break;

              case 'candidate':
                //message is iceCandidate
                myPC ? myPC.addIceCandidate(new RTCIceCandidate(data.candidate)) : "";

              break;

              case 'sdp':
                //message is signal description
                myPC ? myPC.setRemoteDescription(new RTCSessionDescription(data.sdp)) : "";

              break;

              case 'typingStatus':
                if(data.status){
                    document.getElementById("typingInfo").innerHTML = "Remote is typing ......";
                }

                else{
                    document.getElementById("typingInfo").innerHTML = "";
                }

              break;

              case 'newMessage':
                addRemoteChat(data.msg, data.date);

                //play msg tone
                document.getElementById('msgTone').play();

              break;

              case 'newSub':
                console.log(data.user +" Is Online");
                connection.send
                (JSON.stringify
                ({
                    action: 'imOnline',
                    user: user
                }));
              break;
            }
        };

        function newMessage() {

            var message = $(".message-input input").val();

            if($.trim(message) == '') {
                return false;
            }

            SaveMessagetoDatabase(message);
            var d = new Date();
            console.log(user);
            console.log(room);
            connection.send(JSON.stringify({
                action: 'newMessage',
                user: user,
                date:d.getFullYear()+d.getMonth()+d.getDate(),
                msg: message,
                room: room
            }));
            // var msg={"event":"","content":"","from":"","to":"","room":""};
            //PushMessageRealtime(msg);

            $('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>'
                + message + '</p></li>').appendTo($('.messages ul'));
            $('.message-input input').val(null);
            $('.contact.active .preview').html('<span>You: </span>' + message);

            $(".messages").animate({ scrollTop: $(".messages").get(0).scrollHeight }, "fast");
            //  console.log($(document).height());
            //  console.log($(".messages").get(0).scrollHeight);


            // $(".messages").attr("scrollTop",);
        };

        function addRemoteChat(msg,date)
        {
            $('<li class="replies"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>'
            + msg + '</p></li>').appendTo($('.messages ul'));
            $('.contact.active .preview').html('<span>You: </span>' + msg);

            var spancounts=$('.contact .newmsgcount');

            for (i = 0; i <  allrooms.length; i++)
            {
                console.log(spancounts[i]);
                var currentcount= spancounts[i].innerHTML==null?0:spancounts[i].innerHTML;
                spancounts[i].innerHTML= parseInt(currentcount)+1;
            }

            $(".messages").animate({ scrollTop: $(".messages").get(0).scrollHeight }, "fast");
       }
       function updateContactStatus(data)
       {
         var contacts = $("#contacts li");
         var status=data.status;
         var user=data.user;
         contacts.each(function(idx, li) {
             var contact = $(li);
             if(contact.attr("id")==user)
             {
                 contact.find("span").removeClass("online").addClass(status);
             }
             // and the rest of your code
         });
       }
       function GetChatHistory()
       {
            console.log("getting chat history");
            $.ajax({
              url: "ajaxserver.php",
              type: 'POST',
              dataType: "JSON",
              data: {
                  'event':"getmessages",
                  'sid': currentuser,
                  'rid': connectedtouser,
              },
              success: function(response){
                  console.log(response);
                  if(response.conId)
                  {
                        console.log("set it up");
                        room.conversationid=response.conId;
                  }
                  else
                  {
                    console.log("Got it");
                    var data=response;
                    messages=data.data;
                    UpdateView(messages);
                  }
                  //alert("The response is"+response);
              //   var data=JSON.parse(response);
              }
          });
       }
       function UpdateView(messages)
      {
            var newhtml="";
            if(messages!==[])
            {
                console.log("The message length is "+ messages.length);
              //  alert(messages);
                for(var i = 0; i < messages.length; i++)
                {
                    //console.log(messages[i].body);
                    if(messages[i].sender===currentuser)
                    {
                      $('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>'
                      + messages[i].body + '</p></li>').appendTo($('.messages ul'));
                    }
                    else
                    {
                      $('<li class="replies"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>'
                      + messages[i].body + '</p></li>').appendTo($('.messages ul'));
                    }
                    room.conversationid=messages[i].conId;
                }
                $(".messages").animate({ scrollTop: $(".messages").get(0).scrollHeight }, "fast");
                console.log(room.conversationid);
            }
        }
       function createChatRoom(user1d,user2d)
       {
            console.log(user1d);
            var roomid = Math.random().toString(36).slice(2).substring(0, 15);
            room.id=roomid;
            room.user1=user1d;
            room.user2=user2d;
            var newroom={id:roomid,user1:user1d,user2:user2d,conversationid:""};
            allrooms.push(newroom);
            console.log(room);
            return room;
       }
       function getChatRoom(currentuser,connectedtouser)
       {
          resetroom();
          console.log(allrooms);
          for (i = 0; i <  allrooms.length; i++)
          {
              // console.log(rooms[i]);
              //console.log(rooms[i].id);
              if( allrooms[i].user1===currentuser &&  allrooms[i].user2===connectedtouser)
              {
                  room= allrooms[i];
              }
          }
          console.log("Found Room"+room.id);
          if(room.id=="")
          {
               room=createChatRoom(currentuser,connectedtouser);
          }

          return room;
       }
       function resetroom()
       {
           room.id="";
           room.user1="";
           room.user2="";
       }
       function removeChatRoom()
       {

       }
       function UpgradeCallConnection()
       {

       }
       function InitializeCall(calltype)
       {
           var room=getChatRoom(currentuser,connectedtouser);

            //    var room=createChatRoom(currentuser,connectedtouser);
            //document.getElementById("rcivModal").style.display = 'none';
            if(checkUserMediaSupport){
                //set media constraints based on the button clicked. Audio only should be initiated by default
                    streamConstraints = calltype === 'video' ? {video:{facingMode:'user'}, audio:true} : {audio:true};

                    //set message to display on the call dialog
                    callerInfo.style.color = 'black';
                    callerInfo.innerHTML = calltype === 'video' ? 'Video call to Remote' : 'Audio call to Remote';

                    $("#spinners-home-overlay").show(1000);
                    console.log(room.id);
                    switch(calltype)
                    {
                        case "video":
                        // StartVideoCall();
                        break;
                        case "voice":
                        // StartVoiceCall();
                        break;
                        default:

                    }
                    //start calling tone
                    document.getElementById('callerTone').play();
                    //notify callee that we're calling. Don't call startCall() yet
                    connection.send(JSON.stringify({
                        action: 'initCall',
                        msg: calltype === 'video' ? "Video call from remote" : "Audio call from remote",
                        user:user,
                        room: room
                    }));

                    //disable call buttons
                    //disableCallBtns();

                    //wait for response for 30secs
                    awaitingResponse = setTimeout(function(){
                        EndVideoCall("Call ended due to lack of response", true);
                    }, 30000);
                }
          //  StartCounter();
       }
       function StartVoiceCall()
       {

       }
       function ClearUnreadMessagesCount()
       {
            var spancounts=$('.contact .newmsgcount');

            for (i = 0; i <  allrooms.length; i++)
            {
                console.log(spancounts[i]);
                spancounts[i].innerHTML= null;
            }
       }
       function StartCounter()
       {
            var sec = "00";
            var min = "00";
            var hr = "00";

            var hrElem = document.querySelector("#countHr");
            var minElem = document.querySelector("#countMin");
            var secElem = document.querySelector("#countSec");

            hrElem.innerHTML = hr;
            minElem.innerHTML = min;
            secElem.innerHTML = sec;

            setInterval(function(){
                //display seconds and increment it by a sec
                ++sec;

                secElem.innerHTML = sec >= 60 ? "00" : (sec < 10 ? "0"+sec : sec);

                if(sec >= 60){
                    //increase minute and reset secs to 00
                    ++min;
                    minElem.innerHTML = min < 10 ? "0"+min : min;

                    sec = 0;

                    if(min >= 60){
                        //increase hr by one and reset min to 00
                        ++hr;
                        hrElem.innerHTML = hr < 10 ? "0"+hr : hr;

                        min = 0;
                    }
                }

            }, 1000);
        }
        function SaveMessagetoDatabase(msg)
        {
          console.log(room.conversationid + msg  +currentuser +connectedtouser);
          $.ajax({
            url: "ajaxserver.php",
            type: 'POST',
            dataType: "JSON",
            data: {
                'event':"newmessage",
                'sid': currentuser,
                'rid': connectedtouser,
                'cid': room.conversationid,
                'body':msg
            },
            success: function(response){
                console.log("The post response is "+response);
                //alert("The response is"+response);
            //   var data=JSON.parse(response);
                // var data=response;
                // messages=data.data;
                // UpdateView(messages);
            }
        });
        }
       function StartVideoCall()
       {
            $("#spinners-home-overlay").show(2000);

            if(videolinkpress)
            {
                navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then(function(camera) {

                    // preview camera during recording
                    document.getElementById('peerVid').muted = true;
                    document.getElementById('peerVid').srcObject = camera;

                    document.getElementById('myVid').muted = true;
                    document.getElementById('myVid').srcObject = camera;

                });
            }
            return false;
       }
       function EndVideoCall(msg, setTimeOut)
       {
            connection.send(JSON.stringify({
                action: 'endCall',
                msg: msg,
                user:user,
                room: room
            }));

            if(setTimeOut){
                //display message
                document.getElementById("callerInfo").style.color = 'red';
                document.getElementById.innerHTML = "<i class='fa fa-exclamation-triangle'></i> No response";

                setTimeout(function(){
                    document.getElementById("callModal").style.display = 'none';
                }, 3000);

                //enableCallBtns();
            }

            else{
                document.getElementById("callModal").style.display = 'none';
            }

            clearTimeout(awaitingResponse);

            document.getElementById('callerTone').pause();
            $("#spinners-home-overlay").hide(1000);
            setTimeout(function()
            {
                $("#video-link").attr("disabled",false);
                videolinkpress=false;
            },2000);
            //videolinkpress=false;
       }
       function EnableSocketConnection()
       {

       }
       function CloseSocketConnection()
       {

       }
       function SaveCallRecording(blob,type,fileName)
       {
                // Create an instance of FormData and append the video parameter that
                // will be interpreted in the server as a file
               // var blob = recorder instanceof Blob ? recorder : recorder.blob;
               var fileType = blob.type.split('/')[0] || 'audio';
               if(type==="remote")
               {
                    fileName +="-2";
               }
               else
               {
                    fileName +="-1";
               }
               
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
       /** Video Stuff */
        function checkUserMediaSupport(){
            return !!(navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
        }
        // Answer Call media
        function answerCall(){
            console.log("answering call");
            //check whether user can use webrtc and use that to determine the response to send
            if(checkUserMediaSupport){

                console.log("  Can use web rtc");
                //set media constraints based on the button clicked. Audio only should be initiated by default
                streamConstraints = this.id === 'startVideo' ? {video:{facingMode:'user'}, audio:true} : {audio:true};

                //show msg that we're setting up call (i.e. locating servers)
               // document.getElementById("calleeInfo").innerHTML = "<i class='"+spinnerClass+"'></i> Setting up call...";

                //uncomment the lines below if you comment out the get request above
                startCall(true);

                //dismiss modal
                document.getElementById("rcivModal").style.display = 'none';

                //enable the terminateCall btn
               // disableCallBtns();

            }

            else{
                //inform caller and current user (i.e. receiver) that he cannot use webrtc, then dismiss modal after a while
                connection.send(JSON.stringify({
                    action: 'callRejected',
                    msg: "Remote's device does not have the necessary requirements to make call",
                    room: room
                }));

                document.getElementById("calleeInfo").innerHTML = "Your browser/device does not meet the minimum requirements needed to make a call";

                setTimeout(function(){
                    document.getElementById("rcivModal").style.display = 'none';
                }, 3000);
            }

            document.getElementById('callerTone').pause();
        }
        // Start Call media
        function startCall(isCaller){

            console.log("Starting Call");

            if(checkUserMediaSupport){

                console.log("Media support Confirmed");

                myPC = new RTCPeerConnection(servers);//RTCPeerconnection obj

                console.log(myPC);
                //When my ice candidates become available
                myPC.onicecandidate = function(e){
                    if(e.candidate){
                        console.log("Sending Candidate to Perrt");
                        //send my candidate to peer
                        connection.send(JSON.stringify({
                            action: 'candidate',
                            candidate: e.candidate,
                            room: room
                        }));
                    }
                };

                //When remote stream becomes available
                myPC.ontrack = function(e){
                    document.getElementById("peerVid").src = window.URL.createObjectURL(e.streams[0]);
                    remoterecorder=RecordRTC(e.streams[0], {
                        mimeType: 'video/webm',
                        bitsPerSecond: 128000
                    });
                    // document.getElementById("peerVid").src = window.HTMLMediaElement.srcObject(e.streams[0]);
                };


                //when remote connection state and ice agent is closed
                myPC.oniceconnectionstatechange = function(){
                    switch(myPC.iceConnectionState){
                        case 'disconnected':
                        case 'failed':
                            console.log("Ice connection state is failed/disconnected");
                            showSnackBar("Call connection problem", 15000);
                            break;

                        case 'closed':
                            console.log("Ice connection state is 'closed'");
                            showSnackBar("Call connection closed", 15000);
                            break;
                    }
                };


                //WHEN REMOTE CLOSES CONNECTION
                myPC.onsignalingstatechange = function(){
                    switch(myPC.signalingState){
                        case 'closed':
                            console.log("Signalling state is 'closed'");
                            showSnackBar("Signal lost", 15000);
                            break;
                    }
                };

                //set local media
                setLocalMedia(streamConstraints, isCaller);
            }

            else{
                showSnackBar("Your browser does not support video call", 30000);
            }
        }
         //get and set local media
        function setLocalMedia(streamConstraints, isCaller){
            navigator.mediaDevices.getUserMedia(streamConstraints).then(function(myStream){
                document.getElementById("myVid").src = window.URL.createObjectURL(myStream);
                // document.getElementById("peerVid").src = window.HTMLMediaElement.srcObject(e.streams[0]);
                recorder = RecordRTC(myStream, {
                    mimeType: 'video/webm',
                    bitsPerSecond: 128000
                });
                myPC.addStream(myStream);//add my stream to RTCPeerConnection

                //set var myMediaStream as the stream gotten. Will be used to remove stream later on
                myMediaStream = myStream;

                if(isCaller){
                    myPC.createOffer().then(description, function(e){
                        console.log("Error creating offer", e.message);

                        showSnackBar("Call connection failed", 15000);
                    });

                    //then notify callee to start call on his end
                    connection.send(JSON.stringify({
                        action: 'startCall',
                        room: room
                    }));
                }

                else{
                    //myPC.createAnswer(description);
                    myPC.createAnswer().then(description).catch(function(e){
                        console.log("Error creating answer", e);

                        showSnackBar("Call connection failed", 15000);
                    });

                }

            }).catch(function(e){

                switch(e.name){
                    case 'SecurityError':
                        console.log(e.message);

                        showSnackBar("Media sources usage is not supported on this browser/device", 10000);
                        break;

                    case 'NotAllowedError':
                        console.log(e.message);

                        showSnackBar("We do not have access to your audio/video sources", 10000);
                        break;

                    case 'NotFoundError':
                        console.log(e.message);

                        showSnackBar("The requested audio/video source cannot be found", 10000);
                        break;

                    case 'NotReadableError':
                    case 'AbortError':
                        console.log(e.message);
                        showSnackBar("Unable to use your media sources", 10000);
                        break;
                }
            });
        }
        //get pc description
        function description(desc){
            myPC.setLocalDescription(desc);

            //send sdp
            connection.send(JSON.stringify({
                action: 'sdp',
                sdp: desc,
                room: room
            }));
        }
        function handleCallTermination(){
            myPC ? myPC.close() : "";//close connection as well

            //tell user that remote terminated call
            showSnackBar("Call terminated by remote", 10000);

            //remove streams and free media devices
            stopMediaStream();

            //remove video playback src
            $('video').attr('src', appRoot+'img/vidbg.png');

            //enable 'call' button and disable 'terminate call' btn
            //enableCallBtns();
        }
        function showSnackBar(msg, displayTime){
            document.getElementById('snackbar').innerHTML = msg;
            document.getElementById('snackbar').className = document.getElementById('snackbar').getAttribute('class') + " show";

            setTimeout(function(){
                $("#snackbar").html("").removeClass("show");
            }, displayTime);
        }
       //# sourceURL=pen.js
});
