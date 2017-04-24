<?php session_start();

date_default_timezone_set('Pacific/Auckland');

require 'includes/functions.php';


$host = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'forum';


$dbh = connectDatabase($host,$database,$user,$pass);
$topics = getTopics($dbh);
