<?php
    // Start the session to access session variables
    session_start();

    // Include and run the database connection file
    require_once 'dbh.inc.php';

    if (!isset($_SESSION['SID'])) {
        header("Location: ../staff_login.php");
        exit();
    }

    if (isset($_POST["changePassword"])) {
        $staffID = $_SESSION["SID"];
        $currentPassword = $_POST["currentPassword"];
        $newPassword = $_POST["newPassword"];
        $confirmNewPassword = $_POST["confirmNewPassword"];

        // Check if new passwords match
        if ($newPassword !== $confirmNewPassword) {
            header("Location: ../dashboards/staff_dashboard.php?status=passwordMismatch");
            exit();
        }

        // Get current password hash from database
        $sql_getPassword = "SELECT staffPassword FROM openday_staff_info WHERE SID = ?";
        $stmt_getPassword = $dbconnection->prepare($sql_getPassword);
        $stmt_getPassword->bind_param("i", $staffID);
        $stmt_getPassword->execute();
        $result = $stmt_getPassword->get_result();
        $row = $result->fetch_assoc();

        if (!$row || !password_verify($currentPassword, $row["staffPassword"])) {
            header("Location: ../dashboards/staff_dashboard.php?status=incorrectPassword");
            exit();
        }

        // Hash new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in database
        $sql_updatePassword = "UPDATE openday_staff_info SET staffPassword = ? WHERE SID = ?";
        $stmt_updatePassword = $dbconnection->prepare($sql_updatePassword);
        
        if (!$stmt_updatePassword) {
            header("Location: ../dashboards/staff_dashboard.php?status=stmtError");
            exit();
        }

        $stmt_updatePassword->bind_param("si", $hashedNewPassword, $staffID);

        if ($stmt_updatePassword->execute()) {
            header("Location: ../dashboards/staff_dashboard.php?status=success");
        } else {
            header("Location: ../dashboards/staff_dashboard.php?status=stmtError");
        }

        exit();
    }

    header("Location: ../dashboards/staff_dashboard.php");
    exit();
?>