<?php
// Connect to database
$dbconnection = new mysqli("localhost","2350327","8g5sps","db2350327");
if ($dbconnection -> connect_errno) {
echo "Failed to connect to MySQL: " . $dbconnection -> connect_error;
exit();
}