<?php
session_start();
require 'db.php';

$max_attempts = 5;  // Maximum allowed login attempts
$lockout_time = 15; // // Cooldown is set to 15 seconds. In a real-scenario this would be set much higher, however this is just for testing.
$current_time = time();

// Initialising failed login attempt tracking
if (!isset($_SESSION['failed_login_attempts'])) {
    $_SESSION['failed_login_attempts'] = 0;
    $_SESSION['last_failed_login'] = 0;
}

// Checking if the user is locked out
if ($_SESSION['failed_login_attempts'] >= $max_attempts) {
    $time_since_last_attempt = $current_time - $_SESSION['last_failed_login'];
    
    if ($time_since_last_attempt < $lockout_time) {
        $time_remaining = $lockout_time - $time_since_last_attempt;
        die("Too many failed attempts. Please try again in $time_remaining seconds.");
    } else {
        // Reset failed attempts after lockout period ends
        $_SESSION['failed_login_attempts'] = 0;
        $_SESSION['last_failed_login'] = 0;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $fullname, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // Successful login resets failed attempts
            $_SESSION['failed_login_attempts'] = 0;
            $_SESSION['last_failed_login'] = 0;

            $_SESSION['user_id'] = $user_id;
            $_SESSION['fullname'] = $fullname; // Store the full name

            header("Location: dashboard.php"); // Redirect to dashboard
            exit;
        }
    }
    // If login fails, failed login attempts count increases
    $_SESSION['failed_login_attempts']++;
    $_SESSION['last_failed_login'] = $current_time;

    die("Invalid login credentials.");
}
?>