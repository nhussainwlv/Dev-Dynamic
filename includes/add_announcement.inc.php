<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['SID'])) {
    header("Location: ../staff_login.php");
    exit();
}

// Retrieve Form Data
$announcementModule = $_POST["announcementModule"];
$announcementVisibility = $_POST["announcementVisibility"];
$announcementContent = $_POST["announcementContent"];
$staffID = $_SESSION['SID'];

// Enforce Lecturer Restrictions
if ($_SESSION['staffRole'] === "Lecturer" && $_SESSION['staffModule'] !== $announcementModule) {
    header("Location: ../dashboards/staff_dashboard.php?error=invalidModule");
    exit();
}

// Insert Announcement
$sql = "INSERT INTO openday_announcements (announcementModule, announcementVisibility, announcementContent, staffID) VALUES (?, ?, ?, ?)";
$stmt = $dbconnection->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $dbconnection->error);
}

$stmt->bind_param("sssi", $announcementModule, $announcementVisibility, $announcementContent, $staffID);

if ($stmt->execute()) {
    header("Location: ../dashboards/staff_dashboard.php?status=announcementAdded");
} else {
    header("Location: ../dashboards/staff_dashboard.php?error=stmtError");
}

exit();
?>