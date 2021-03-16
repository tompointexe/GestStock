<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbhost = "localhost";
$dbuser = "geststock";
$dbpass = "My!Secure!Password";
$dbname = "geststock";
$bdd = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass);
$bdd->exec("SET CHARACTER SET utf8");
?>