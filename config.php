<?php
# Database connection here inlakssnap
global $dbc;
DEFINE ('DB_HOSTNAME', 'localhost');
DEFINE ('DB_DATABASE', 'test');

//DEFINE ('DB_DATABASE', 'inlakssnap');
DEFINE ('DB_USERNAME', 'root');
DEFINE ('DB_PASSWORD', '');

$dbc = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Could not connect because: '.mysqli_connect__error());

?>