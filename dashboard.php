<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to your Dashboard</h2>
    <a href="logout.php">Logout</a>
</body>
</html>
