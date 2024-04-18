<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/util.php';
require __DIR__ . '/user_util.php';
require __DIR__ . '/company_util.php';

if(!isLogged()) {
    header("Location: company_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
<div class="container">
    <ul class="notifications"></ul>
    <h2>Welcome to Your Dashboard</h2>
    <p>Hello, <?php echo getSessionName(); ?>!</p>
    <div class="tabs">
        <a href="company_dashboard.php" class="tablink">Home</a>
        <a href="company_vacancy.php" class="tablink">Vacancy</a>
        <a href="company_profile.php" class="tablink">Profile</a>
        <a href="/api/logout" class="tablink">Logout</a>
    </div>
    <div class="content">
        <!-- Content for Home tab goes here -->
        <p>This is the Home tab content.</p>
    </div>
</div>
<script src="js/toast.js"></script>
</body>
</html>


