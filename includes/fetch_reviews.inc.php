<?php
require_once 'dbh.inc.php';

// Get only approved reviews and author name
$sql = "SELECT openday_reviews.reviewRole, openday_reviews.reviewContent, 
               openday_user_info.fullName 
        FROM openday_reviews
        JOIN openday_user_info ON openday_reviews.userID = openday_user_info.UID
        WHERE openday_reviews.reviewStatus = 'approved'
        ORDER BY openday_reviews.reviewID DESC";

$result = $dbconnection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='review-box'>";
        echo htmlspecialchars($row["reviewRole"]) . " Review by: <strong>" . htmlspecialchars($row["fullName"]) . "</strong></p>";
        echo "<p>" . nl2br(htmlspecialchars($row["reviewContent"])) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No approved reviews yet.</p>";
}
?>