<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/util.php';
require __DIR__ . '/user_util.php';
require __DIR__ . '/company_util.php';
require __DIR__ . '/admin_util.php';

if(!isLoggedAdmin()) {
    header("Location: admin_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
<ul class="notifications"></ul>
<div class="container">
    <h2>Welcome to Admin Dashboard</h2>
    <a href="/api/logout" class="tablink">Logout</a>

    <h3></h3>
</div>
<script src="js/toast.js"></script>
</body>
</html>


