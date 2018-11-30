<?php  
require '../vendor/autoload.php';  
require "../core/config.php";

use Ratchet\MessageComponentInterface;  
use Ratchet\ConnectionInterface;

require 'Chat.php';

//set an array of origins allowed to connect to this server
$allowed_origins = ['localhost', '127.0.0.1','192.168.2.21','0.0.0.0'];

// Run the server application through the WebSocket protocol on port 8080
//$app = new Ratchet\App('192.168.2.21', 8080, '0.0.0.0');//App(hostname, port, 'whoCanConnectIP', '')
$app = new Ratchet\App('localhost', 8080, '0.0.0.0');//App(hostname, port, 'whoCanConnectIP', '')

//create socket routes
//route(uri, classInstance, arrOfAllowedOrigins)
$app->route('/comm', new Chat, $allowed_origins);

// // Run the server application through the WebSocket protocol on port 8080
// $app = new Ratchet\App("localhost", 8080, '0.0.0.0', $loop);

// $app->route('/chat', new Chat, array('*'));

$app->run();