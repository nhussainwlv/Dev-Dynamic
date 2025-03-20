<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php'; // Ensure db.php is correct

$cooldown_time = 15; // Cooldown is set to 15 seconds. In a real-scenario this would be set much higher, however this is just for testing.
$current_time = time();

// Initialise session variable for successful signups
if (!isset($_SESSION['last_successful_signup'])) {
    $_SESSION['last_successful_signup'] = 0;
}

// Blocks users from creating multiple accounts too quickly
if ($current_time - $_SESSION['last_successful_signup'] < $cooldown_time) {
    $time_left = $_SESSION['last_successful_signup'] + $cooldown_time - $current_time;
    die("You must wait $time_left seconds before creating another account.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prevent XSS by sanitising input
    $fullname = htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkStmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?");
    if ($checkStmt) {
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            die("Error: Email already exists. Please use a different email.");
        }
        $checkStmt->close();
    } else {
        die("Database error: " . $mysqli->error);
    }

    // Prepare and execute SQL statement
    $stmt = $mysqli->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);
        if ($stmt->execute()) {
            // Apply signup cooldown
            $_SESSION['last_successful_signup'] = $current_time; // Set the session time now            

            // ✅ Redirect to login page after successful signup
            header("Location: log_in.html");
            exit();
        } else {
            die("❌ Signup failed: " . $stmt->error);
        }
        $stmt->close();
    } else {
        die("❌ Database error: " . $mysqli->error);
    }
} else {
    die("❌ Invalid request!");
}
?>

