<?php 



$host = 'localhost';
$user = 'root';
$password = '';
$db = 'ddldiscount';


$GLOBALS['conn'] = mysqli_connect($host, $user, $password);
mysqli_select_db($GLOBALS['conn'], $db);
?>