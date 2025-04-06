<?php
session_start();
require_once 'dbh.inc.php';

// Sanitize input to prevent XSS
$feedbackName = htmlspecialchars($_POST['feedbackName'], ENT_QUOTES, 'UTF-8');
$feedbackEmail = $_POST['feedbackEmail'];
$feedbackIssue = $_POST['feedbackIssue'];
$feedbackContent = htmlspecialchars($_POST['feedbackContent'], ENT_QUOTES, 'UTF-8');

// Insert Feedback
$sql = "INSERT INTO openday_feedback (feedbackName, feedbackEmail, feedbackIssue, feedbackContent) VALUES (?, ?, ?, ?)";
$stmt = $dbconnection->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $dbconnection->error);
}

$stmt->bind_param("ssss", $feedbackName, $feedbackEmail, $feedbackIssue, $feedbackContent);

if ($stmt->execute()) {
    header("Location: ../help.html?status=feedbackAdded");
} else {
    header("Location: ../help.html?error=stmtError");
}

exit();
?>