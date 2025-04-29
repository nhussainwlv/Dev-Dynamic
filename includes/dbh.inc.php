<?php
// To connect to database please refer to 'filezilla_connection.txt' on Basecamp
$servername = ""; // KEEP "localhost"
$username = "root";  // YOUR_STUDENT_NUMBER
$password = "";      // YOUR_MYSQL_PASSWORD
$dbname = "db2350327";  // db[YOUR_STUDENT_ID]

// Create connection to the database
$dbconnection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($dbconnection->connect_error) {
    die("Connection failed: " . $dbconnection->connect_error);
}


// GUESTS / VISITORS / STUDENTS TABLE
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

// Insert default user account
$userEmail = "user@wlv.ac.uk";
$check_user_sql = "SELECT 1 FROM openday_user_info WHERE userEmail = ?";
$stmt = $dbconnection->prepare($check_user_sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $fullName = "User";
    $userPassword = "user123"; // Default password
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT); // Hash password

    $insert_user_sql = "INSERT INTO openday_user_info (fullName, userEmail, userPassword) VALUES (?, ?, ?)";
    $stmt = $dbconnection->prepare($insert_user_sql);
    $stmt->bind_param("sss", $fullName, $userEmail, $hashedPassword);

    if ($stmt->execute()) {
        echo "User account created successfully.<br>";
    } else {
        die("Error inserting user account: " . $stmt->error);
    }
}


// STAFF / ADMINS TABLE
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
}


// EVENTS TABLE
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
}


// ANNOUNCEMENTS TABLE
// Create Announcements Table (if not exists)
$announcements_table_sql = "CREATE TABLE IF NOT EXISTS openday_announcements (
    announcementID INT AUTO_INCREMENT PRIMARY KEY,
    announcementModule VARCHAR(255) NOT NULL,
    announcementVisibility VARCHAR(255) NOT NULL,
    announcementContent VARCHAR(255) NOT NULL,
    staffID INT NOT NULL,
    FOREIGN KEY (staffID) REFERENCES openday_staff_info(SID)
)";

if ($dbconnection->query($announcements_table_sql) !== TRUE) {
    die("Error creating announcement table: " . $dbconnection->error);
}

// Insert default Announcement
$announcementModule = "Computer Science";
$check_announcement_sql = "SELECT 1 FROM openday_announcements WHERE announcementModule = ?";
$stmt = $dbconnection->prepare($check_announcement_sql);
$stmt->bind_param("s", $announcementModule);
$stmt->execute();
$result = $stmt->get_result();

// Dummy test data
if ($result->num_rows == 0) {
    $announcementVisibility = "All";
    $announcementContent = "Test Announcement #1";
    $announcementStaffID = "1";

    $insert_announcement_sql = "INSERT INTO openday_announcements (announcementModule, announcementVisibility, announcementContent, staffID) VALUES (?, ?, ?, ?)";
    $stmt = $dbconnection->prepare($insert_announcement_sql);
    $stmt->bind_param("ssss", $announcementModule, $announcementVisibility, $announcementContent, $announcementStaffID);

    if ($stmt->execute()) {
        echo "Announcement created successfully.<br>";
    } else {
        die("Error inserting Announcement: " . $stmt->error);
    }
}


// HELP / FEEDBACK TABLE
// Create Help and Feedback Table (if not exists)
$feedback_table_sql = "CREATE TABLE IF NOT EXISTS openday_feedback (
    feedbackID INT AUTO_INCREMENT PRIMARY KEY,
    feedbackName VARCHAR(255) NOT NULL,
    feedbackEmail VARCHAR(255) NOT NULL,
    feedbackIssue VARCHAR(255) NOT NULL,
    feedbackContent TEXT NOT NULL
)";

if ($dbconnection->query($feedback_table_sql) !== TRUE) {
    die("Error creating feedback table: " . $dbconnection->error);
}

// Insert default Feedback issue if not exists
$feedbackEmail = "feedbackTest@wlv.ac.uk";
$check_feedback_sql = "SELECT 1 FROM openday_feedback WHERE feedbackEmail = ?";
$stmt = $dbconnection->prepare($check_feedback_sql);
$stmt->bind_param("s", $feedbackEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $feedbackName = "FeedbackName 1";
    $feedbackIssue = "Course Help";
    $feedbackContent = "test feedback 123"; 

    $insert_feedback_sql = "INSERT INTO openday_feedback (feedbackName, feedbackEmail, feedbackIssue, feedbackContent) VALUES (?, ?, ?, ?)";
    $stmt = $dbconnection->prepare($insert_feedback_sql);
    $stmt->bind_param("ssss", $feedbackName, $feedbackEmail, $feedbackIssue, $feedbackContent);

    if ($stmt->execute()) {
        echo "Feedback issue created successfully.<br>";
    } else {
        die("Error inserting Feedback issue: " . $stmt->error);
    }
}


// REVIEWS TABLE
// Create Reviews Table (if not exists)
$review_table_sql = "CREATE TABLE IF NOT EXISTS openday_reviews (
    reviewID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    FOREIGN KEY (userID) REFERENCES openday_user_info(UID),
    reviewRole VARCHAR(255) NOT NULL,
    reviewContent TEXT NOT NULL,
    reviewStatus ENUM('pending', 'approved', 'denied') DEFAULT 'pending'
)";

if ($dbconnection->query($review_table_sql) !== TRUE) {
    die("Error creating reviews table: " . $dbconnection->error);
}

// Insert default Reviews if not exists
$reviewRole = "Student";
$check_review_sql = "SELECT 1 FROM openday_reviews WHERE reviewRole = ?";
$stmt = $dbconnection->prepare($check_review_sql);
$stmt->bind_param("s", $reviewRole);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $userID = "1";
    $reviewContent = "test review 123"; 
    $reviewStatus = "pending";

    $insert_review_sql = "INSERT INTO openday_reviews (userID, reviewRole, reviewContent, reviewStatus) VALUES (?, ?, ?, ?)";
    $stmt = $dbconnection->prepare($insert_review_sql);
    $stmt->bind_param("ssss", $userID, $reviewRole, $reviewContent, $reviewStatus);

    if ($stmt->execute()) {
        echo "Review issue created successfully.<br>";
    } else {
        die("Error inserting Review: " . $stmt->error);
    }
}

?>