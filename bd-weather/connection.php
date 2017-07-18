<?php

$server = "localhost";
$username = "username";
$password = "password";
$database = "septembe_facebookapp";
$connect = mysql_connect($server, $username, $password) or die(mysql_error());
$selectdb = mysql_select_db($database) or die (mysql_error());

?>
