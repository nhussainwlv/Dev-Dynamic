<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php'; // Ensure db.php is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL statement
    $stmt = $mysqli->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);
        if ($stmt->execute()) {
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

