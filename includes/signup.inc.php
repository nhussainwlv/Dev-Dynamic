<?php
// Secure session settings
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Strict' // Prevents CSRF attacks by restricting cross-site cookie usage
]);

session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$cooldown_time = 15; // Cooldown set to 15 seconds for testing
$current_time = time();

// Initialize signup cooldown if not set
if (!isset($_SESSION['last_successful_signup'])) {
    $_SESSION['last_successful_signup'] = 0;
}

// Block users from creating multiple accounts too quickly
if ($current_time - $_SESSION['last_successful_signup'] < $cooldown_time) {
    $time_left = $_SESSION['last_successful_signup'] + $cooldown_time - $current_time;
    die("You must wait $time_left seconds before creating another account.");
}

// Generate CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF validation failed!");
    }

    // Sanitize input to prevent XSS
    $fullName = htmlspecialchars($_POST['FullName'], ENT_QUOTES, 'UTF-8');
    $userEmail = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
    $userConfirmEmail = filter_var($_POST['ConfirmEmail'], FILTER_SANITIZE_EMAIL);
    $userPassword = $_POST['Password'];
    $userConfirmPassword = $_POST['ConfirmPassword'];

    // Error handling
    if (missingArgument($userEmail, $userConfirmEmail, $userPassword, $userConfirmPassword)) {
        header("location: ../signup.php?errorcode=MissingArgument");
        exit();
    }

    if (invalidEmail($userEmail)) {
        header("location: ../signup.php?errorcode=InvalidEmail");
        exit();
    }

    if (passwordLength($userPassword)) {
        header("location: ../signup.php?errorcode=InvalidPasswordLength");
        exit();
    }

    if (emailMatch($userEmail, $userConfirmEmail)) {
        header("location: ../signup.php?errorcode=EmailsDontMatch");
        exit();
    }

    if (passwordMatch($userPassword, $userConfirmPassword)) {
        header("location: ../signup.php?errorcode=PasswordsDontMatch");
        exit();
    }

    if (existingUserEmail($dbconnection, $userEmail)) { 
        header("location: ../signup.php?errorcode=EmailAlreadyExists");
        exit();
    }

    // Create new user
    createUserInfo($dbconnection, $fullName, $userEmail, $userPassword);

    // Apply signup cooldown
    $_SESSION['last_successful_signup'] = $current_time;

    // Regenerate CSRF token after successful signup
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    exit();
} else {
    header("location: ../signup.php");
    exit();
}
?>