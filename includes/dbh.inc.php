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
    staffPassword VARCHAR(255) NOT NULL,
    staffModule VARCHAR(255) NOT NULL DEFAULT 'Unspecified',
    staffRole VARCHAR(255) NOT NULL DEFAULT 'Unspecified'
)";

if ($dbconnection->query($staff_table_sql) !== TRUE) {
    die("Error creating staff table: " . $dbconnection->error);
}

// Insert default Admin account if not exists
$adminEmail = "admin@wlv.ac.uk";
$check_admin_sql = "SELECT 1 FROM openday_staff_info WHERE staffEmail = ?";
$stmt = $dbconnection->prepare($check_admin_sql);
$stmt->bind_param("s", $adminEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $adminName = "Admin";
    $adminPassword = "admin123"; // Default password
    $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT); // Hash password
    $adminModule = "ADMIN"; 
    $adminRole = "ADMIN"; // Admin Role

    $insert_admin_sql = "INSERT INTO openday_staff_info (staffName, staffEmail, staffPassword, staffModule, staffRole) VALUES (?, ?, ?, ?, ?)";
    $stmt = $dbconnection->prepare($insert_admin_sql);
    $stmt->bind_param("sssss", $adminName, $adminEmail, $hashedPassword, $adminModule, $adminRole);

    if ($stmt->execute()) {
        echo "Admin account created successfully.<br>";
    } else {
        die("Error inserting admin account: " . $stmt->error);
    }
} else {
    echo "Admin account already exists.<br>";
}

// Create Events Table (if not exists)
$events_table_sql = "CREATE TABLE IF NOT EXISTS openday_events (
    eventID INT AUTO_INCREMENT PRIMARY KEY,
    eventModule VARCHAR(255) NOT NULL,
    eventType VARCHAR(255) NOT NULL,
    eventLocation VARCHAR(255) NOT NULL,
    eventRoom VARCHAR(255) NOT NULL,
    eventDateTime DATETIME NOT NULL,
    staffID INT NOT NULL,
    FOREIGN KEY (staffID) REFERENCES openday_staff_info(SID)
)";

if ($dbconnection->query($events_table_sql) !== TRUE) {
    die("Error creating events table: " . $dbconnection->error);
}

// Insert default Event
$eventModule = "Computer Science";
$check_event_sql = "SELECT 1 FROM openday_events WHERE eventModule = ?";
$stmt = $dbconnection->prepare($check_event_sql);
$stmt->bind_param("s", $eventModule);
$stmt->execute();
$result = $stmt->get_result();

// Dummy test data
if ($result->num_rows == 0) {
    $eventType = "Open Day";
    $eventLocation = "Wolverhampton City Campus: Alan Turing Building";
    $eventRoom = "MI206"; 
    $eventDateTime = "2025-05-07 10:00:00";
    $eventStaffID = "1";

    $insert_event_sql = "INSERT INTO openday_events (eventModule, eventType, eventLocation, eventRoom, eventDateTime, staffID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $dbconnection->prepare($insert_event_sql);
    $stmt->bind_param("ssssss", $eventModule, $eventType, $eventLocation, $eventRoom, $eventDateTime, $eventStaffID);

    if ($stmt->execute()) {
        echo "Event created successfully.<br>";
    } else {
        die("Error inserting event: " . $stmt->error);
    }
} else {
    echo "Event already exists.<br>";
}

?>