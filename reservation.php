<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php'; // Ensure db.php exists in htdocs/

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['date']) || !isset($_POST['time'])) {
        die("❌ Error: Missing date or time.");
    }

    $date = $_POST['date'];
    $time = $_POST['time'];

    // Ensure the database connection is successful
    if ($mysqli->connect_error) {
        die("❌ Database connection failed: " . $mysqli->connect_error);
    }

    // Insert into database
    $stmt = $mysqli->prepare("INSERT INTO reservations (date, time) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $date, $time);
        if ($stmt->execute()) {
            echo "✅ Reservation successful!";
        } else {
            echo "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "❌ Database error: " . $mysqli->error;
    }
} else {
    die("❌ Invalid request! This page only accepts POST requests.");
}
?>
