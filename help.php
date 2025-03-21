<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php'; // Ensure this file is correct

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['fullname'], $_POST['email'], $_POST['message'])) {
        die("❌ Error: All fields are required.");
    }

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $mysqli->prepare("INSERT INTO help_requests (fullname, email, message) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $fullname, $email, $message);
        if ($stmt->execute()) {
            echo "✅ Help request submitted successfully!";
        } else {
            echo "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "❌ Database error: " . $mysqli->error;
    }
} else {
    die("❌ Invalid request! Only POST requests are allowed.");
}
?>
