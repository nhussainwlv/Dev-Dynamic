<?php
    // Start the session to access session variables
    session_start();

    // Include and run the database connection file
    require_once 'dbh.inc.php';

    // Sanitise input to prevent XSS
    $userID = $_SESSION['UID'];
    $reviewRole = $_POST['reviewRole'];
    $reviewContent = htmlspecialchars($_POST['reviewContent'], ENT_QUOTES, 'UTF-8');

    // Insert Review
    $sql = "INSERT INTO openday_reviews (userID, reviewRole, reviewContent) VALUES (?, ?, ?)";
    $stmt = $dbconnection->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $dbconnection->error);
    }

    $stmt->bind_param("iss", $userID, $reviewRole, $reviewContent);

    if ($stmt->execute()) {
        header("Location: ../dashboards/dashboard.php?status=reviewAdded");
    } else {
        header("Location: ../dashboards/dashboard.php?error=stmtError");
    }

    exit();
?>