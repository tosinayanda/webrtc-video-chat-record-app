<!DOCTYPE html>
<?php 
      session_start();

      if(!isset($_SESSION['username'])){
              header("location:../login.php");
      }
      // var_dump($_SESSION);
      // exit();
      $currentuser=$_SESSION['username'];
      include("core/config.php");
      $company = mysqli_query($dbc,"SELECT * FROM company where status='ACTIVE'");
	    $companydata=mysqli_fetch_array($company);
			
            //$name2 = $accountndata['group_name'];
			//$image = $personal_details['cust_image'];
			$company_name = $companydata['company_name'];
			$logo = $companydata['logo'];
			
			$headercolor = $companydata['headercolor'];
			
			$footercolor = $companydata['footercolor'];
			
			$logo=$companydata['logo'];
      global $users;
      $usersresult= mysqli_query($dbc,"SELECT * FROM users");
      while($data = mysqli_fetch_array($usersresult)){
              $users[]=$data;   
              // var_dump($data);
              // exit();                                                                                        
          }
      ?>
<html class=''>
<head>
<!-- <script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script>
<script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script>
<script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script> -->
<meta charset='UTF-8'>
<meta name="robots" content="noindex">
<link rel="shortcut icon" href="../img/favicon.ico">
<title>INLAKS CRM</title>
<!-- <link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/emilcarlsson/pen/ZOQZaV?limit=all&page=74&q=contact+" /> -->
<link href='css/font.style.css' rel='stylesheet' type='text/css'>
<script src="js/jquery.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://cdn.webrtc-experiment.com/style.css">
<script src="js/RecordRTC.js"></script>
<script src="https://cdn.webrtc-experiment.com/gif-recorder.js"></script>
<script src="https://cdn.webrtc-experiment.com/getScreenId.js"></script>
<!-- for Edige/FF/Chrome/Opera/etc. getUserMedia support -->
<script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
<script src="js/bootstrap.min.js"></script>


<script src="js/hoy3lrg.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<link rel='stylesheet prefetch' href='css/reset.min.css'>
<!-- <link rel='stylesheet' href='css/font-awesome.min.css'> -->
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
<style class="cp-pen-styles">
      body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      font-family: "proxima-nova", "Source Sans Pro", sans-serif;
      font-size: 1em;
      letter-spacing: 0.1px;
      color: #32465a;
      text-rendering: optimizeLegibility;
      text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
      -webkit-font-smoothing: antialiased;
    }

    #frame {
      width: 100%;
      min-width: 360px;
      max-width: 100%;
      height: 92vh;
      min-height: 300px;
      max-height: 720px;
      background: #E6EAEA;
    }
    @media screen and (max-width: 360px) {
      #frame {
        width: 100%;
        height: 100vh;
      }
    }
    #frame #sidepanel {
      float: left;
      min-width: 280px;
      max-width: 340px;
      width: 40%;
      height: 100%;
      background: #2c3e50;
      color: #f5f5f5;
      overflow: hidden;
      position: relative;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel {
        width: 58px;
        min-width: 58px;
      }
    }
    #frame #sidepanel #profile {
      width: 80%;
      margin: 25px auto;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile {
        width: 100%;
        margin: 0 auto;
        padding: 5px 0 0 0;
        background: #32465a;
      }
    }
    #frame #sidepanel #profile.expanded .wrap {
      height: 210px;
      line-height: initial;
    }
    #frame #sidepanel #profile.expanded .wrap p {
      margin-top: 20px;
    }
    #frame #sidepanel #profile.expanded .wrap i.expand-button {
      -moz-transform: scaleY(-1);
      -o-transform: scaleY(-1);
      -webkit-transform: scaleY(-1);
      transform: scaleY(-1);
      filter: FlipH;
      -ms-filter: "FlipH";
    }
    #frame #sidepanel #profile .wrap {
      height: 60px;
      line-height: 60px;
      overflow: hidden;
      -moz-transition: 0.3s height ease;
      -o-transition: 0.3s height ease;
      -webkit-transition: 0.3s height ease;
      transition: 0.3s height ease;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap {
        height: 55px;
      }
    }
    #frame #sidepanel #profile .wrap img {
      width: 50px;
      border-radius: 50%;
      padding: 3px;
      border: 2px solid #e74c3c;
      height: auto;
      float: left;
      cursor: pointer;
      -moz-transition: 0.3s border ease;
      -o-transition: 0.3s border ease;
      -webkit-transition: 0.3s border ease;
      transition: 0.3s border ease;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap img {
        width: 40px;
        margin-left: 4px;
      }
    }
    #frame #sidepanel #profile .wrap img.online {
      border: 2px solid #2ecc71;
    }
    #frame #sidepanel #profile .wrap img.away {
      border: 2px solid #f1c40f;
    }
    #frame #sidepanel #profile .wrap img.busy {
      border: 2px solid #e74c3c;
    }
    #frame #sidepanel #profile .wrap img.offline {
      border: 2px solid #95a5a6;
    }
    #frame #sidepanel #profile .wrap p {
      float: left;
      margin-left: 15px;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap p {
        display: none;
      }
    }
    #frame #sidepanel #profile .wrap i.expand-button {
      float: right;
      margin-top: 23px;
      font-size: 0.8em;
      cursor: pointer;
      color: #435f7a;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap i.expand-button {
        display: none;
      }
    }
    #frame #sidepanel #profile .wrap #status-options {
      position: absolute;
      opacity: 0;
      visibility: hidden;
      width: 150px;
      margin: 70px 0 0 0;
      border-radius: 6px;
      z-index: 99;
      line-height: initial;
      background: #435f7a;
      -moz-transition: 0.3s all ease;
      -o-transition: 0.3s all ease;
      -webkit-transition: 0.3s all ease;
      transition: 0.3s all ease;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap #status-options {
        width: 58px;
        margin-top: 57px;
      }
    }
    #frame #sidepanel #profile .wrap #status-options.active {
      opacity: 1;
      visibility: visible;
      margin: 75px 0 0 0;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap #status-options.active {
        margin-top: 62px;
      }
    }
    #frame #sidepanel #profile .wrap #status-options:before {
      content: '';
      position: absolute;
      width: 0;
      height: 0;
      border-left: 6px solid transparent;
      border-right: 6px solid transparent;
      border-bottom: 8px solid #435f7a;
      margin: -8px 0 0 24px;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap #status-options:before {
        margin-left: 23px;
      }
    }
    #frame #sidepanel #profile .wrap #status-options ul {
      overflow: hidden;
      border-radius: 6px;
    }
    #frame #sidepanel #profile .wrap #status-options ul li {
      padding: 15px 0 30px 18px;
      display: block;
      cursor: pointer;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap #status-options ul li {
        padding: 15px 0 35px 22px;
      }
    }
    #frame #sidepanel #profile .wrap #status-options ul li:hover {
      background: #496886;
    }
    #frame #sidepanel #profile .wrap #status-options ul li span.status-circle {
      position: absolute;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin: 5px 0 0 0;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap #status-options ul li span.status-circle {
        width: 14px;
        height: 14px;
      }
    }
    #frame #sidepanel #profile .wrap #status-options ul li span.status-circle:before {
      content: '';
      position: absolute;
      width: 14px;
      height: 14px;
      margin: -3px 0 0 -3px;
      background: transparent;
      border-radius: 50%;
      z-index: 0;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap #status-options ul li span.status-circle:before {
        height: 18px;
        width: 18px;
      }
    }
    #frame #sidepanel #profile .wrap #status-options ul li p {
      padding-left: 12px;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #profile .wrap #status-options ul li p {
        display: none;
      }
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-online span.status-circle {
      background: #2ecc71;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-online.active span.status-circle:before {
      border: 1px solid #2ecc71;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-away span.status-circle {
      background: #f1c40f;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-away.active span.status-circle:before {
      border: 1px solid #f1c40f;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-busy span.status-circle {
      background: #e74c3c;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-busy.active span.status-circle:before {
      border: 1px solid #e74c3c;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-offline span.status-circle {
      background: #95a5a6;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-offline.active span.status-circle:before {
      border: 1px solid #95a5a6;
    }
    #frame #sidepanel #profile .wrap #expanded {
      padding: 100px 0 0 0;
      display: block;
      line-height: initial !important;
    }
    #frame #sidepanel #profile .wrap #expanded label {
      float: left;
      clear: both;
      margin: 0 8px 5px 0;
      padding: 5px 0;
    }
    #frame #sidepanel #profile .wrap #expanded input {
      border: none;
      margin-bottom: 6px;
      background: #32465a;
      border-radius: 3px;
      color: #f5f5f5;
      padding: 7px;
      width: calc(100% - 43px);
    }
    #frame #sidepanel #profile .wrap #expanded input:focus {
      outline: none;
      background: #435f7a;
    }
    #frame #sidepanel #search {
      border-top: 1px solid #32465a;
      border-bottom: 1px solid #32465a;
      font-weight: 300;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #search {
        display: none;
      }
    }
    #frame #sidepanel #search label {
      position: absolute;
      margin: 10px 0 0 20px;
    }
    #frame #sidepanel #search input {
      font-family: "proxima-nova",  "Source Sans Pro", sans-serif;
      padding: 10px 0 10px 46px;
      width: calc(100% - 25px);
      border: none;
      background: #32465a;
      color: #f5f5f5;
    }
    #frame #sidepanel #search input:focus {
      outline: none;
      background: #435f7a;
    }
    #frame #sidepanel #search input::-webkit-input-placeholder {
      color: #f5f5f5;
    }
    #frame #sidepanel #search input::-moz-placeholder {
      color: #f5f5f5;
    }
    #frame #sidepanel #search input:-ms-input-placeholder {
      color: #f5f5f5;
    }
    #frame #sidepanel #search input:-moz-placeholder {
      color: #f5f5f5;
    }
    #frame #sidepanel #contacts {
      height: calc(100% - 177px);
      overflow-y: scroll;
      overflow-x: hidden;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #contacts {
        height: calc(100% - 149px);
        overflow-y: scroll;
        overflow-x: hidden;
      }
      #frame #sidepanel #contacts::-webkit-scrollbar {
        display: none;
      }
    }
    #frame #sidepanel #contacts.expanded {
      height: calc(100% - 334px);
    }
    #frame #sidepanel #contacts::-webkit-scrollbar {
      width: 8px;
      background: #2c3e50;
    }
    #frame #sidepanel #contacts::-webkit-scrollbar-thumb {
      background-color: #243140;
    }
    #frame #sidepanel #contacts ul li.contact {
      position: relative;
      padding: 10px 0 15px 0;
      font-size: 0.9em;
      cursor: pointer;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #contacts ul li.contact {
        padding: 6px 0 46px 8px;
      }
    }
    #frame #sidepanel #contacts ul li.contact:hover {
      background: #32465a;
    }
    #frame #sidepanel #contacts ul li.contact.active {
      background: #32465a;
      border-right: 5px solid #435f7a;
    }
    #frame #sidepanel #contacts ul li.contact.active span.contact-status {
      border: 2px solid #32465a !important;
    }
    #frame #sidepanel #contacts ul li.contact .wrap {
      width: 88%;
      margin: 0 auto;
      position: relative;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #contacts ul li.contact .wrap {
        width: 100%;
      }
    }
    #frame #sidepanel #contacts ul li.contact .wrap span {
      position: absolute;
      left: 0;
      margin: -2px 0 0 -2px;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      border: 2px solid #2c3e50;
      background: #95a5a6;
    }
    #frame #sidepanel #contacts ul li.contact .wrap span.online {
      background: #2ecc71;
    }
    #frame #sidepanel #contacts ul li.contact .wrap span.away {
      background: #f1c40f;
    }
    #frame #sidepanel #contacts ul li.contact .wrap span.busy {
      background: #e74c3c;
    }
    #frame #sidepanel #contacts ul li.contact .wrap img {
      width: 40px;
      border-radius: 50%;
      float: left;
      margin-right: 10px;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #contacts ul li.contact .wrap img {
        margin-right: 0px;
      }
    }
    #frame #sidepanel #contacts ul li.contact .wrap .meta {
      padding: 5px 0 0 0;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #contacts ul li.contact .wrap .meta {
        display: none;
      }
    }
    #frame #sidepanel #contacts ul li.contact .wrap .meta .name {
      font-weight: 600;
    }
    #frame #sidepanel #contacts ul li.contact .wrap .meta .preview {
      margin: 5px 0 0 0;
      padding: 0 0 1px;
      font-weight: 400;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      -moz-transition: 1s all ease;
      -o-transition: 1s all ease;
      -webkit-transition: 1s all ease;
      transition: 1s all ease;
    }
    #frame #sidepanel #contacts ul li.contact .wrap .meta .preview span {
      position: initial;
      border-radius: initial;
      background: none;
      border: none;
      padding: 0 2px 0 0;
      margin: 0 0 0 1px;
      opacity: .5;
    }
    #frame #sidepanel #bottom-bar {
      position: absolute;
      width: 100%;
      bottom: 0;
    }
    #frame #sidepanel #bottom-bar button {
      float: left;
      border: none;
      width: 50%;
      padding: 10px 0;
      background: #32465a;
      color: #f5f5f5;
      cursor: pointer;
      font-size: 0.85em;
      font-family: "proxima-nova",  "Source Sans Pro", sans-serif;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #bottom-bar button {
        float: none;
        width: 100%;
        padding: 15px 0;
      }
    }
    #frame #sidepanel #bottom-bar button:focus {
      outline: none;
    }
    #frame #sidepanel #bottom-bar button:nth-child(1) {
      border-right: 1px solid #2c3e50;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #bottom-bar button:nth-child(1) {
        border-right: none;
        border-bottom: 1px solid #2c3e50;
      }
    }
    #frame #sidepanel #bottom-bar button:hover {
      background: #435f7a;
    }
    #frame #sidepanel #bottom-bar button i {
      margin-right: 3px;
      font-size: 1em;
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #bottom-bar button i {
        font-size: 1.3em;
      }
    }
    @media screen and (max-width: 735px) {
      #frame #sidepanel #bottom-bar button span {
        display: none;
      }
    }
    #frame .content {
      float: right;
      width: 60%;
      height: 100%;
      overflow: hidden;
      position: relative;
    }
    @media screen and (max-width: 735px) {
      #frame .content {
        width: calc(100% - 58px);
        min-width: 300px !important;
      }
    }
    @media screen and (min-width: 900px) {
      #frame .content {
        width: calc(100% - 340px);
      }
    }
    #frame .content .contact-profile {
      width: 100%;
      height: 60px;
      line-height: 60px;
      background: #f5f5f5;
    }
    #frame .content .contact-profile img {
      width: 40px;
      border-radius: 50%;
      float: left;
      margin: 9px 12px 0 9px;
    }
    #frame .content .contact-profile p {
      float: left;
    }
    #frame .content .contact-profile .social-media {
      float: right;
    }
    #frame .content .contact-profile .social-media i {
      margin-left: 14px;
      cursor: pointer;
    }
    #frame .content .contact-profile .social-media i:nth-last-child(1) {
      margin-right: 20px;
    }
    #frame .content .contact-profile .social-media i:hover {
      color: #435f7a;
    }
    #frame .content .messages {
      height: auto;
      min-height: calc(100% - 93px);
      max-height: calc(100% - 93px);
      overflow-y: scroll;
      overflow-x: hidden;
    }
    @media screen and (max-width: 735px) {
      #frame .content .messages {
        max-height: calc(100% - 105px);
      }
    }
    #frame .content .messages::-webkit-scrollbar {
      width: 8px;
      background: transparent;
    }
    #frame .content .messages::-webkit-scrollbar-thumb {
      background-color: rgba(0, 0, 0, 0.3);
    }
    #frame .content .messages ul li {
      display: inline-block;
      clear: both;
      float: left;
      margin: 15px 15px 5px 15px;
      width: calc(100% - 25px);
      font-size: 0.9em;
    }
    #frame .content .messages ul li:nth-last-child(1) {
      margin-bottom: 20px;
    }
    #frame .content .messages ul li.sent img {
      margin: 6px 8px 0 0;
    }
    #frame .content .messages ul li.sent p {
      background: #435f7a;
      color: #f5f5f5;
    }
    #frame .content .messages ul li.replies img {
      float: right;
      margin: 6px 0 0 8px;
    }
    #frame .content .messages ul li.replies p {
      background: #f5f5f5;
      float: right;
    }
    #frame .content .messages ul li img {
      width: 22px;
      border-radius: 50%;
      float: left;
    }
    #frame .content .messages ul li p {
      display: inline-block;
      padding: 10px 15px;
      border-radius: 20px;
      max-width: 205px;
      line-height: 130%;
    }
    @media screen and (min-width: 735px) {
      #frame .content .messages ul li p {
        max-width: 300px;
      }
    }
    #frame .content .message-input {
      position: absolute;
      bottom: 0;
      width: 100%;
      z-index: 99;
    }
    #frame .content .message-input .wrap {
      position: relative;
    }
    #frame .content .message-input .wrap input {
      font-family: "proxima-nova",  "Source Sans Pro", sans-serif;
      float: left;
      border: none;
      width: calc(100% - 90px);
      padding: 11px 32px 10px 8px;
      font-size: 0.8em;
      color: #32465a;
    }
    @media screen and (max-width: 735px) {
      #frame .content .message-input .wrap input {
        padding: 15px 32px 16px 8px;
      }
    }
    #frame .content .message-input .wrap input:focus {
      outline: none;
    }
    #frame .content .message-input .wrap .attachment {
      position: absolute;
      right: 60px;
      z-index: 4;
      margin-top: 10px;
      font-size: 1.1em;
      color: #435f7a;
      opacity: .5;
      cursor: pointer;
    }
    @media screen and (max-width: 735px) {
      #frame .content .message-input .wrap .attachment {
        margin-top: 17px;
        right: 65px;
      }
    }
    #frame .content .message-input .wrap .attachment:hover {
      opacity: 1;
    }
    #frame .content .message-input .wrap button {
      float: right;
      border: none;
      width: 50px;
      padding: 12px 0;
      cursor: pointer;
      background: #32465a;
      color: #f5f5f5;
    }
    @media screen and (max-width: 735px) {
      #frame .content .message-input .wrap button {
        padding: 16px 0;
      }
    }
    #frame .content .message-input .wrap button:hover {
      background: #435f7a;
    }
    #frame .content .message-input .wrap button:focus {
      outline: none;
    }
</style>
<style>
  .badge
  {
    position:absolute;
    /* margin:0 auto; */
    right:1em;
    top:1em;
    font-size:90%;
    color:#fff;
    background:blue;
    opacity:0.7;
    border-radius:50%;
  }
</style>
</head>
<body style=" background-color:<?php echo $headercolor ?>;opacity:0.95">
<?php 
                $userdepartments=$_SESSION['department'];
                $date1=date("y/m/d");
                $counts1 = mysqli_query($dbc,"SELECT *, COUNT(*) FROM `crmcomplainttable` where `RESPONSIBLE_DEPARTMENT`='$userdepartments' AND `CONTACT_STATUS`!='COMPLETED' AND `RESPONSIBLE_DEPARTMENT`!=''");
								$counts1data = mysqli_fetch_array($counts1);
								$totalaccounts=$counts1data['COUNT(*)'];
								
								$t24id=$counts1data['t24id'];
								
                $serverstatusnew = mysqli_query($dbc,"SELECT * FROM connectiontest where id='1'");
								$serverstatusnewdata = mysqli_fetch_array($serverstatusnew);
                $serverstatus=$serverstatusnewdata['testcode'];	
                
               
																
?>
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<img id="profile-img" src="http://emilcarlsson.se/assets/mikeross.png" class="online" alt="" />
				<p><?php echo strtoupper($_SESSION['username'])?></p>
				<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
				<div id="status-options">
					<ul>
						<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
						<li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
						<li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
						<li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
					</ul>
				</div>
				<div id="expanded">
					<label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mikeross" />
					<label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="ross81" />
					<label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mike.ross" />
				</div>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" id="searchholder" placeholder="Search contacts..." onkeyup="myFunction()"/>
		</div>
		<div id="contacts">
			<ul id="contactsul">
        <?php foreach($users as $user):?>
          <?php if (strtoupper($user["username"]) !== strtoupper($_SESSION["username"])):?>
            <li class="contact" id="<?php echo $user["username"];?>">
              <span class=" newmsgcount badge badge-pill" id="<?php echo $user["username"];?>"></span>
              <div class="wrap">
                <span class="contact-status online"></span>
                
                <img src="avataricon.png" alt="" /> 
                <div class="meta">
                  <p class="name"><?php echo $user["name"];?></p>
                  <p class="preview">You just got LITT up, Mike.</p>
                  
                </div>
              </div>
            </li>
          <?php endif;?>
        <?php endforeach;?>
			</ul>
		</div>
		<div id="bottom-bar">
			<button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
			<button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
		</div>
	</div>
	<div class="content">
		<div class="contact-profile">
			<img src="" alt="" />
			<p id="connected-to"></p>
			<div class="social-media">
        
        <i class="fa fa-envelope" aria-hidden="true" id="email-link"></i>
				<i class="fa fa-microphone" aria-hidden="true" id="voice-call-link"></i>        
				<i class="fa fa-microphone-slash" aria-hidden="true" id="voice-mute-link"></i>
				 <i class="fa fa-video-camera" aria-hidden="true" id="video-link"></i>
			</div>
		</div>
		<div class="messages">
			<ul>
			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
      <span id="typingInfo"></span>
			<input type="text" placeholder="Write your message..." />
			<i class="fa fa-paperclip attachment" aria-hidden="true"></i>
			<button id="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>

 <div id="spinners-home-overlay" class="hidden">
    <div class="container-fluid">
      <div id="snackbar"></div>
        <div class="row">
            <!-- Remote Video -->
            <video id="peerVid" poster="vidbg.png" playsinline autoplay></video>
            <!-- Remote Video -->
        </div>
        <style>
          .circle-icon {
              background:white;
              /* opacity:0.1; */
              /* padding:5px; */
              width:5em;
              height:5em;
              border-radius: 50%;
          }

          #callBtns button
          {
              margin:2em;
              -webkit-transition: opacity 0.2s; /* Safari */
              transition: opacity 0.2s;
          }
          
          #callBtns button:hover
          {
              opacity:0.1;
          }

          #recordCall img
          {
            width:100%;
            height:100%;
          }
        </style>
        <div class="row margin-top-20">                
            <!-- Call Buttons -->
            <div class="col-sm-12 text-center" id="callBtns" style="position:fixed; bottom:20%;center:50%;">
                <!--  -->
                <!-- <button class="btn btn-success btn-sm initCall" id="initAudio"><i class="fa fa-phone fa-2x circle-icon"></i></button>
                <button class="btn btn-info btn-sm initCall" id="initVideo"><i class="fa fa-video-camera fa-2x circle-icon"></i></button> -->
                <!-- <button class="btn btn-sm btn-success" id="acceptCall" disabled><i class="fa fa-phone fa-4x "></i></button> -->
                <button class="btn btn-sm btn-danger circle-icon" id="terminateCall" disabled><i class="fa fa-phone fa-3x"></i></button>
                <button class="btn btn-sm circle-icon" id="recordCall" disabled><img src="record.png"/></button>
                <button class="btn btn-sm circle-icon" id="endCallRecording" disabled><i class="fa fa-stop-circle-o fa-3x" style="color:red"></i></button>

            </div>
            <!-- Call Buttons -->
            
            <!-- Timer -->
            <div class="col-sm-12 text-center margin-top-5" style="color:#fff;position:fixed; bottom:15%;center:50%;">
                <span id="countHr"></span>h:
                <span id="countMin"></span>m:
                <span id="countSec"></span>s
            </div>
            <!-- Timer -->
        </div>
        
        
        <!-- Local Video -->
        <div class="row">
            <div class="col-sm-12">
                <video id="myVid" poster="vidbg.png" muted autoplay></video>
            </div>
        </div>
        <!-- Local Video -->
    </div>

    <!--Modal to show that we are calling-->
    <div id="callModal" class="modal">
        <div class="modal-content text-center">
            <div class="modal-header" id="callerInfo"></div>

            <div class="modal-body">
                <button type="button" class="btn btn-danger btn-sm" id='endCall'>
                    <i class="fa fa-times-circle"></i> End Call
                </button>
            </div>
        </div>
    </div>
    <!--Modal end-->


    <!--Modal to give options to receive call-->
    <div id="rcivModal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="calleeInfo"></div>

            <div class="modal-body text-center">
                <button type="button" class="btn btn-success btn-sm answerCall" id='startAudio'>
                    <i class="fa fa-phone"></i> Audio Call
                </button>
                <button type="button" class="btn btn-success btn-sm answerCall" id='startVideo'>
                    <i class="fa fa-video-camera"></i> Video Call
                </button>
                <button type="button" class="btn btn-danger btn-sm" id='rejectCall'>
                    <i class="fa fa-times-circle"></i> Reject Call
                </button>
            </div>
        </div>
    </div>
    
 </div>
 <script type="text/javascript">
  // capture camera and/or microphone

 </script>
 <!-- <script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script> -->
 <!-- <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script> -->
<style>
    #typingInfo{
      font-size: 10px;
      color:  #3a87ad;
  }
  #spinners-home-overlay
  {
      position: absolute;
      left: 0%;
      top: 0%;
      width:100%;
      height:100%;
      z-index: 9999;
      background-color:black;
      opacity:1;
      transition: opacity 2s ease-in-out;
  }
  /* VIDEO */
  #peerVid{
      position: fixed;
      top: 50%;
      left: 50%;
      min-width: 100%;
      min-height: 100%;
      width: auto;
      height: auto;
      z-index: -100;
      border: 2px solid white;
      -ms-transform: translateX(-50%) translateY(-50%);
      -moz-transform: translateX(-50%) translateY(-50%);
      -webkit-transform: translateX(-50%) translateY(-50%);
      transform: translateX(-50%) translateY(-50%);
      background: url("vidbg.png") no-repeat;
      background-size: cover;
  }
  
  #myVid{
      width: 300px;
      height: 200px;
      bottom: 0;
      border: 2px solid white;
      background-image: linear-gradient(#56787a, black);
      position: fixed;
      right: 0;
  }
  
  
  /* Small screens */
  @media(max-width:768px){
      #myVid{
          width: 200px;
          height: 100px;
          bottom: 100px;
          position: fixed;
          left: 0;
      }
  }
 
 /* _VIDEO */
 </style>

<script>
  function myFunction() {
      // Declare variables
      var input, filter, ul, li, a, i;
      input = document.getElementById('searchholder');
      //console.log(input.value);
      filter = input.value.toUpperCase();
      ul = document.getElementById("contactsul");
      li = ul.getElementsByTagName('li');
      //console.log(ul);

      // Loop through all list items, and hide those who don't match the search query
      for (i = 0; i < li.length; i++) {
          a = li[i].getElementsByTagName("p")[0];
          //console.log(li[i]);
          if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
          } else {
              li[i].style.display = "none";
          }
      }
  }
</script>
 <script>
 var currentsessionuser= "<?php echo $_SESSION['username'];?>";
 $(function()
 {
  //console.log(currentsessionuser);
 });

</script>
 <script src="vidochat.js"></script>
 <audio id="callerTone" src="callertone.mp3" loop preload="auto"></audio>
 <audio id="msgTone" src="msgtone.mp3" preload="auto"></audio>
</body>
</html>