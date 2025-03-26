<?php
// Connect to database
$dbconnection = new mysqli("localhost", "2350327", "8g5sps", "db2350327");

// Check connection
if ($dbconnection->connect_error) {
    die("Connection failed: " . $dbconnection->connect_error);
}
?>