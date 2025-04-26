<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav style="position: relative; overflow: hidden; width: 100%; box-sizing: border-box; padding-right: 20px;">
    <ul class="sidebar">
        <li onclick="hideSidebar()"><a href="#"><svg>...</svg></a></li>
        <li><a href="index.php" <?php if ($currentPage == 'index.php') echo 'style="color: red;"'; ?>>Home</a></li>
        <li><a href="map.php" <?php if ($currentPage == 'map.php') echo 'style="color: red;"'; ?>>Map</a></li>
        <li><a href="book_reservation.php" <?php if ($currentPage == 'book_reservation.php') echo 'style="color: red;"'; ?>>Book Reservation</a></li>
        <li><a href="help.php" <?php if ($currentPage == 'help.php') echo 'style="color: red;"'; ?>>Help</a></li>
        <li><a href="course.php" <?php if ($currentPage == 'course.php') echo 'style="color: red;"'; ?>>Courses</a></li>
        <li><a href="accommodation.php" <?php if ($currentPage == 'accommodation.php') echo 'style="color: red;"'; ?>>Accommodation</a></li>

        <?php if (isset($_SESSION["SID"])): ?>
            <li><a href="dashboards/staff_dashboard.php" <?php if ($currentPage == 'staff_dashboard.php') echo 'style="color: red;"'; ?>>Staff Dashboard</a></li>
        <?php elseif (isset($_SESSION["UID"])): ?>
            <li><a href="dashboards/dashboard.php" <?php if ($currentPage == 'dashboard.php') echo 'style="color: red;"'; ?>>Dashboard</a></li>
        <?php else: ?>
            <!-- Show login/signup links only if not logged in -->
            <li><a href="signup.php" <?php if ($currentPage == 'signup.php') echo 'style="color: red;"'; ?>>Sign Up</a></li>
            <li><a href="login.php" <?php if ($currentPage == 'login.php') echo 'style="color: red;"'; ?>>Log In</a></li>
        <?php endif; ?>
    </ul>

    <ul>
        <li class="responsiveHeader"><a href="index.php" <?php if ($currentPage == 'index.php') echo 'style="color: red;"'; ?>>Home</a></li>
        <li class="responsiveHeader"><a href="map.php" <?php if ($currentPage == 'map.php') echo 'style="color: red;"'; ?>>Map</a></li>
        <li class="responsiveHeader"><a href="book_reservation.php" <?php if ($currentPage == 'book_reservation.php') echo 'style="color: red;"'; ?>>Book Reservation</a></li>
        <li class="responsiveHeader"><a href="help.php" <?php if ($currentPage == 'help.php') echo 'style="color: red;"'; ?>>Help</a></li>
        <li class="responsiveHeader"><a href="course.php" <?php if ($currentPage == 'course.php') echo 'style="color: red;"'; ?>>Courses</a></li>
        <li class="responsiveHeader"><a href="accommodation.php" <?php if ($currentPage == 'accommodation.php') echo 'style="color: red;"'; ?>>Accommodation</a></li>

        <?php if (isset($_SESSION["SID"])): ?>
            <li class="responsiveHeader"><a href="dashboards/staff_dashboard.php" <?php if ($currentPage == 'staff_dashboard.php') echo 'style="color: red;"'; ?>>Staff Dashboard</a></li>
        <?php elseif (isset($_SESSION["UID"])): ?>
            <li class="responsiveHeader"><a href="dashboards/dashboard.php" <?php if ($currentPage == 'dashboard.php') echo 'style="color: red;"'; ?>>Dashboard</a></li>
        <?php else: ?>
            <!-- Show login/signup links only if not logged in -->
            <li class="responsiveHeader"><a href="signup.php" <?php if ($currentPage == 'signup.php') echo 'style="color: red;"'; ?>>Sign Up</a></li>
            <li class="responsiveHeader"><a href="login.php" <?php if ($currentPage == 'login.php') echo 'style="color: red;"'; ?>>Log In</a></li>
        <?php endif; ?>

        <li class="menu-icon" onclick="showSidebar()"><a href="#"><svg>...</svg></a></li>
    </ul>

    <a href="https://www.wlv.ac.uk/" target="_blank" style="position: absolute; top: 10px; right: 10px;">
        <img src="https://www.wlv.ac.uk/media/2019-template-assets/graphics/logo.svg" 
             alt="Wolverhampton University Logo" 
             style="height: 50px; width: auto; max-width: calc(100% - 20px); filter: brightness(0);">
    </a>
</nav>