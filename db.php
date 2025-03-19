<?php
$host = "sql213.infinityfree.com";  
$user = "if0_38554238";     
$pass = "31Ry4Kg9L7";  // Use the password 
$dbname = "if0_38554238_wlv_companion"; 
$mysqli = new mysqli($host, $user, $pass, $dbname);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}
?>

