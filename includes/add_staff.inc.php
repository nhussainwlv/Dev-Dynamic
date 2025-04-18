<?php
    // Start the session to access session variables
    session_start();
    
    // Include and run the database connection file
    require_once 'dbh.inc.php';

    if (!isset($_SESSION['SID']) || $_SESSION["staffRole"] !== "ADMIN") {
        header("Location: ../staff_login.php");
        exit();
    }

    if (isset($_POST["addStaff"])) {
        $staffName = filter_var($_POST["staffName"]);
        $staffEmail = filter_var($_POST["staffEmail"], FILTER_SANITIZE_EMAIL);
        $staffPassword = $_POST["staffPassword"];
        $staffModule = !empty($_POST["staffModule"]) ? $_POST["staffModule"] : "Unspecified"; // Default to "Unspecified"
        $staffRole = !empty($_POST["staffRole"]) ? $_POST["staffRole"] : "Unspecified"; // Default to "Unspecified"

        // Check if email already exists
        $sql_check = "SELECT * FROM openday_staff_info WHERE staffEmail = ?";
        $stmt_check = $dbconnection->prepare($sql_check);
        $stmt_check->bind_param("s", $staffEmail);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            header("Location: ../dashboards/admin_dashboard.php?status=emailExists");
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($staffPassword, PASSWORD_DEFAULT);

        // Insert new staff member
        $sql_insert = "INSERT INTO openday_staff_info (staffName, staffEmail, staffPassword, staffModule, staffRole) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $dbconnection->prepare($sql_insert);
        
        if (!$stmt_insert) {
            header("Location: ../dashboards/admin_dashboard.php?status=stmtError");
            exit();
        }

        $stmt_insert->bind_param("sssss", $staffName, $staffEmail, $hashedPassword, $staffModule, $staffRole);
        
        if ($stmt_insert->execute()) {
            header("Location: ../dashboards/admin_dashboard.php?status=success");
        } else {
            header("Location: ../dashboards/admin_dashboard.php?status=stmtError");
        }

        exit();
    }

    header("Location: ../dashboards/admin_dashboard.php");
    exit();
?>