<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['SID'])) {
    header("Location: ../staff_login.php");
    exit();
}

// Retrieve Form Data
$eventModule = $_POST["eventModule"];
$eventType = $_POST["eventType"];
$eventLocation = $_POST["eventLocation"];
$eventRoom = $_POST["eventRoom"];
$eventDateTime = $_POST["eventDateTime"];
$staffID = $_SESSION['SID'];

// Enforce Lecturer Restrictions
if ($_SESSION['staffRole'] === "Lecturer" && $_SESSION['staffModule'] !== $eventModule) {
    header("Location: ../dashboards/staff_dashboard.php?error=invalidModule");
    exit();
}

// Ensure Room Matches Location
$validRooms = [
    "Wolverhampton City Campus: Alan Turing Building" => ["MI206", "MI207"],
    "Wolverhampton City Campus: Millennium City Building" => ["MC001", "MC002"],
    "Wolverhampton City Campus: Wulfruna Building" => ["MA204", "MA205"]
];

if (!in_array($eventRoom, $validRooms[$eventLocation] ?? [])) {
    header("Location: ../dashboards/staff_dashboard.php?error=invalidRoom");
    exit();
}

// Insert Event
$sql = "INSERT INTO openday_events (eventModule, eventType, eventLocation, eventRoom, eventDateTime, staffID) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $dbconnection->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $dbconnection->error);
}

$stmt->bind_param("sssssi", $eventModule, $eventType, $eventLocation, $eventRoom, $eventDateTime, $staffID);

if ($stmt->execute()) {
    header("Location: ../dashboards/staff_dashboard.php?status=eventAdded");
} else {
    header("Location: ../dashboards/staff_dashboard.php?error=stmtError");
}

exit();
?>