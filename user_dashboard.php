<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/util.php';
require __DIR__ . '/user_util.php';
require __DIR__ . '/company_util.php';

if(!isLogged()) {
    header("Location: user_login.php");
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
    <ul class="notifications"></ul>
    <div class="container">
        <h2>Welcome to Your Dashboard</h2>
        <p>Hello, <?php echo getSessionName(); ?>!</p>
        <div class="tabs">
            <a href="user_dashboard.php" class="tablink">Home</a>
            <a href="user_vacancy.php" class="tablink">Vacancy</a>
            <a href="user_profile.php" class="tablink">Profile</a>
            <a href="/api/logout" class="tablink">Logout</a>
        </div>
        <div class="content">
            <h3>Recent Updates</h3>
            <ul>
                <li><strong>Version 1.0.1 (April 15, 2024):</strong> Added new internship opportunities from top companies.</li>
                <li><strong>Version 1.0 (April 1, 2024):</strong> Launched Intern Match platform. Users can now sign up, log in, and apply for internships.</li>
            </ul>

            <h3>Patch Notes</h3>
            <ul>
                <li><strong>Version 1.0.1:</strong> Fixed minor bugs and improved user experience.</li>
                <li><strong>Version 1.0:</strong> Initial release.</li>
            </ul>
        </div>
    </div>
<script src="js/toast.js"></script>
</body>
</html>


