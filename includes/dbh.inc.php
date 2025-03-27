<?php
// Connect to database
$dbconnection = new mysqli("localhost", "", "", "db"); // To connect to database please refer to 'filezilla_connection.txt' on Basecamp

// Check connection
if ($dbconnection->connect_error) {
    die("Connection failed: " . $dbconnection->connect_error);
}
?>