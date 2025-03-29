<?php
// To connect to database please refer to 'filezilla_connection.txt' on Basecamp
$servername = "localhost"; // KEEP "localhost"
$username = "";  // YOUR_STUDENT_NUMBER
$password = "";      // YOUR_MYSQL_PASSWORD
$dbname = "";  // db[YOUR_STUDENT_ID]

// Create connection to the database
$dbconnection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($dbconnection->connect_error) {
    die("Connection failed: " . $dbconnection->connect_error);
}

// Create GUEST table if it doesn't exist already
$guest_table_sql = "CREATE TABLE IF NOT EXISTS openday_user_info (
    UID INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(255) NOT NULL,
    userEmail VARCHAR(255) NOT NULL UNIQUE,
    userPassword VARCHAR(255) NOT NULL
)";

if ($dbconnection->query($guest_table_sql) !== TRUE) {
    die("Error creating guest table: " . $dbconnection->error);
}

// Create Staff Table (if not exists)
$staff_table_sql = "CREATE TABLE IF NOT EXISTS openday_staff_info (
    SID INT AUTO_INCREMENT PRIMARY KEY,
    staffName VARCHAR(255) NOT NULL,
    staffEmail VARCHAR(255) NOT NULL UNIQUE,
    staffPassword VARCHAR(255) NOT NULL
)";

if ($dbconnection->query($staff_table_sql) !== TRUE) {
    die("Error creating staff table: " . $dbconnection->error);
}

?>