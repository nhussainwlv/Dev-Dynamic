<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$max_attempts = 5;  // Maximum allowed login attempts
$lockout_time = 15; // Cooldown time (seconds)
$current_time = time();

// Initialize failed login attempt tracking if not set
if (!isset($_SESSION['failed_login_attempts'])) {
    $_SESSION['failed_login_attempts'] = 0;
    $_SESSION['last_failed_login'] = 0;
}

// Check if the user is locked out
if ($_SESSION['failed_login_attempts'] >= $max_attempts) {
    $time_since_last_attempt = $current_time - $_SESSION['last_failed_login'];
    
    if ($time_since_last_attempt < $lockout_time) {
        $time_remaining = $lockout_time - $time_since_last_attempt;
        header("location: ../login.php?errorcode=Lockout&time=$time_remaining");
        exit();
    } else {
        // Reset failed attempts after cooldown period
        $_SESSION['failed_login_attempts'] = 0;
        $_SESSION['last_failed_login'] = 0;
    }
}

if (isset($_POST["Submit"])) {
    $userEmail = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
    $userPassword = $_POST['Password'];

    if (missingLoginArgument($userEmail, $userPassword) !== false) {
        header("location: ../login.php?errorcode=MissingArgument");
        exit();
    }

    // Check if user exists in the database
    $userExists = existingUserEmail($dbconnection, $userEmail);

    if (!$userExists) {
        $_SESSION['failed_login_attempts']++;
        $_SESSION['last_failed_login'] = $current_time;
        header("location: ../login.php?errorcode=incorrectEmail");
        exit();
    }

    // Verify password
    if (!password_verify($userPassword, $userExists["userPassword"])) {
        $_SESSION['failed_login_attempts']++;
        $_SESSION['last_failed_login'] = $current_time;
        header("location: ../login.php?errorcode=incorrectPassword");
        exit();
    }

    // Successful login - reset failed attempts
    $_SESSION['failed_login_attempts'] = 0;
    $_SESSION['last_failed_login'] = 0;

    // Set session variables for the user
    $_SESSION["user_id"] = $userExists["UID"];
    $_SESSION["fullname"] = $userExists["userName"]; // Store full name

    loginUser($dbconnection, $userEmail, $userPassword);
    header("location: ../dashboards/dashboard.php?errorcode=LoginSuccessful");
    exit();
}

header("location: ../login.php?errorcode=Unauthorized");
exit();