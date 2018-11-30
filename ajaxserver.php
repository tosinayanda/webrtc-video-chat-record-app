<?php
 include("core/config.php");

 if(isset($_REQUEST["event"]) && $_REQUEST["event"]=="getmessages")
 {
     $sendername=$_REQUEST["sid"];
     $receivername=$_REQUEST["rid"];
     $users=array();
     $response=array();
     $messages=array();
    //  echo $query;
    //  exit();
        $query="SELECT msg.Id,msg.body,msg.created_at,con.Id as conId,msg.author as sender
        from message as msg INNER JOIN conversation as con on con.Id=msg.convId 
        INNER JOIN users as send on send.user_id=con.SenderId INNER JOIN users as recv on recv.user_id=con.ReceiverId where
        (send.username='$sendername' and recv.username='$receivername') or 
        (recv.username='$sendername' and send.username='$receivername') ";
        if(isset($_REQUEST["last_id"]))
        {
            $query.="WHERE msg.Id > ".$_REQUEST["last_id"];
        }
        $result= mysqli_query($dbc,$query);

        // $result=mysqli_fetch_assoc($result);
         //   var_dump($result->{'num_rows'} );
        // exit();
       if($result->{'num_rows'} !== 0)
       {

            while($data = mysqli_fetch_assoc($result))
            {
                    $messages[]=$data;                                                                                           
            }

            $response["data"]=$messages;
            //$response['data']='Bob';
            echo json_encode($response);
       }
       else
       {
           $response["data"]=[];

           $conid=IsConversationCreated($sendername, $receivername);
          // echo "tHE CONV ID IS".$conid;
           if($conid)
           {
                $response["conId"]= $conid;
           }
           else
           {
                $response["conId"]= CreateConversation($sendername, $receivername);
           }
           //$response['data']='Bob';
           echo json_encode($response);
       }
        //echo "12";
        //var_dump($result);
        exit();
   
 }
 if(isset($_REQUEST["event"]) && $_REQUEST["event"]=="newmessage")
 {
    // if(!$_REQUEST["cid"])
    // {
    //     if(!IsConversationCreated($_REQUEST["sid"],$_REQUEST["rid"]))
    //     {
    //         CreateConversation($_REQUEST["sid"],$_REQUEST["rid"]);
    //     }
        // $conid=IsConversationCreated($sendername, $receivername);
        // if($conid)
        // {
        //     $response["conId"]= $conid;
        // }
        // else
        // {
        //     $response["conId"]= CreateConversation($sendername, $receivername);
        // }
    //     exit;
    // }
    $sendername=$_REQUEST["sid"];
    $receivername=$_REQUEST["rid"];
    $conversationid=$_REQUEST["cid"];
    $date=date("Ymd");
    $body=$_REQUEST["body"];

    // $query="INSERT INTO `message`(`Id`, `convId`, `body`, `created_at`,`author`)
    // VALUES ('','$conversationid','$body','$date','$sendername')";
    // echo $query;
    // exit();

    $result= mysqli_query($dbc,"INSERT INTO `message`(`Id`, `convId`, `body`, `created_at`,`author`)
     VALUES ('','$conversationid','$body','$date','$sendername')");

     if($result)
     {
         echo "True";
     }
     else
     {
         echo "Error";
     }
     exit();
 }
 if(isset($_REQUEST["event"]) && $_REQUEST["event"]=="newrecording")
 {
    // if(!$_REQUEST["cid"])
    // {
    //     if(!IsConversationCreated($_REQUEST["sid"],$_REQUEST["rid"]))
    //     {
    //         CreateConversation($_REQUEST["sid"],$_REQUEST["rid"]);
    //     }
        // $conid=IsConversationCreated($sendername, $receivername);
        // if($conid)
        // {
        //     $response["conId"]= $conid;
        // }
        // else
        // {
        //     $response["conId"]= CreateConversation($sendername, $receivername);
        // }
    //     exit;
    // }
    $sendername=$_REQUEST["sid"];
    $receivername=$_REQUEST["rid"];
    $conversationid=$_REQUEST["cid"];
    $date=date("Ymd");
    $body=$_REQUEST["body"];

    // $query="INSERT INTO `message`(`Id`, `convId`, `body`, `created_at`,`author`)
    // VALUES ('','$conversationid','$body','$date','$sendername')";
    // echo $query;
    // exit();
    // upload directory
    $filePath = 'uploads/' . $_POST['video-filename'];

    // path to ~/tmp directory
    $tempName = $_FILES['video-blob']['tmp_name'];
    // move file from ~/tmp to "uploads" directory
    if (!move_uploaded_file($tempName, $filePath)) {
        // failure report
        echo 'Problem saving file: '.$tempName;
        die();
    }

    $result= mysqli_query($dbc,"INSERT INTO `recording`(`Id`, `convId`, `message`, `created_at`,`author`)
     VALUES ('','$conversationid','$body','$date','$sendername')");

     if($result)
     {
         echo "True";
     }
     else
     {
         echo "Error";
     }
     exit();
 }
 function IsConversationCreated($sendername, $receivername)
 {
     global $dbc;
     $response=false;
     $checkquery= mysqli_query($dbc,"SELECT con.Id as conId from conversation as con 
     INNER JOIN users as send on send.user_id=con.SenderId INNER JOIN users as recv on recv.user_id=con.ReceiverId where
       (send.Username='$sendername' and recv.Username='$receivername') or 
       (recv.Username='$sendername' and send.Username='$receivername') ");

       $check=mysqli_fetch_assoc($checkquery);

       if($check)
       {
            $response=$check["conId"];
       }
       return $response;
 }
 function CreateConversation($sendername, $receivername)
 {
        global $dbc;
        $users=array();

        $usersquery= mysqli_query($dbc," SELECT user_id from users where
        (users.Username='$sendername' or users.Username='$receivername')");

       if($usersquery)
       {
            while($data = mysqli_fetch_assoc($usersquery))
            {
                    $users[]=$data;                                                                                           
            }
        }

        var_dump($users);
        $response=false;

        $user1=$users[0]["user_id"];
        $user2=$users[1]["user_id"];

        $createquery= mysqli_query($dbc,"INSERT INTO  `conversation`(`Id`,`SenderId`,`ReceiverId`) VALUES('','$user1','$user2') ");

        if($createquery)
        {
                echo "created a conversation";
                 $response=$createquery["conId"];
        }
        return $response;
 }