<?php
session_start();
require_once 'dbh.inc.php';

if (isset($_POST["Submit"])) {
    $staffEmail = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
    $staffPassword = $_POST['Password'];

    // Validate if email exists
    $sql = "SELECT * FROM openday_staff_info WHERE staffEmail = ?";
    $stmt = $dbconnection->prepare($sql);
    $stmt->bind_param("s", $staffEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $staff = $result->fetch_assoc();

    if (!$staff) {
        header("location: ../staff_login.php?errorcode=invalidEmail");
        exit();
    }

    // Verify password
    if (!password_verify($staffPassword, $staff["staffPassword"])) {
        header("location: ../staff_login.php?errorcode=incorrectPassword");
        exit();
    }

    // Set session variables for staff
    $_SESSION["SID"] = $staff["SID"];
    $_SESSION["staffName"] = $staff["staffName"];
    $_SESSION["staffEmail"] = $staff["staffEmail"];
    $_SESSION["staffModule"] = $staff["staffModule"];
    $_SESSION["staffRole"] = $staff["staffRole"];

    // Redirect to appropriate dashboard
    if ($staff["staffRole"] === "ADMIN") {
        $_SESSION["isAdmin"] = true;
        header("location: ../dashboards/admin_dashboard.php");
    } else {
        $_SESSION["isAdmin"] = false;
        header("location: ../dashboards/staff_dashboard.php");
    }
    exit();
}

header("location: ../staff_login.php?errorcode=Unauthorized");
exit();