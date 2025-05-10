<?php
session_start();
if (!isset($_SESSION['UID'])) {
    header("Location: login.php");
    exit;
}
$fullname = isset($_SESSION['fullName']) ? htmlspecialchars($_SESSION['fullName'], ENT_QUOTES, 'UTF-8') : 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WLV Companion Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional custom styling -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
        }
        .chatbot-container {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            z-index: 1000;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">WLV Companion</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Map</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Accommodation</a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <?php echo $fullname; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container py-5">
    <h2 class="mb-4">Welcome, <?php echo $fullname; ?>!</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Courses</h5>
                    <p class="card-text">Manage your enrolled modules and schedules.</p>
                    <a href="#" class="btn btn-light">View Courses</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Bookings</h5>
                    <p class="card-text">Check or make appointments with services.</p>
                    <a href="#" class="btn btn-light">Manage Bookings</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Accommodation</h5>
                    <p class="card-text">Browse campus housing options and apply.</p>
                    <a href="#" class="btn btn-dark">Explore Accommodation</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chatbot Button -->
<div class="chatbot-container">
    <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#chatbotPanel">
        Chat with us
    </button>
    <div class="collapse mt-2" id="chatbotPanel">
        <div class="card">
            <div class="card-body">
                <p>Hello! How can I help you today?</p>
                <!-- Chatbot logic can go here -->
            </div>
        </div>
    </div>
</div>

</body>
</html>
