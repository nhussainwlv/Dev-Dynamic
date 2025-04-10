<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reviewID = $_POST['reviewID'];
    $action = $_POST['action'];

    if ($action === "approve") {
        $sql = "UPDATE openday_reviews SET reviewStatus = 'approved' WHERE reviewID = ?";
    } elseif ($action === "deny") {
        $sql = "UPDATE openday_reviews SET reviewStatus = 'denied' WHERE reviewID = ?";
    } elseif ($action === "delete") {
        $sql = "DELETE FROM openday_reviews WHERE reviewID = ?";
    } else {
        die("Invalid action.");
    }

    $stmt = $dbconnection->prepare($sql);
    $stmt->bind_param("i", $reviewID);
    $stmt->execute();
    $stmt->close();

    header("Location: ../dashboards/staff_dashboard.php?status=reviewUpdated");
    exit();
}
?>