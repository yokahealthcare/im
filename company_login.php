<?php

session_start();
if(isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['about']) && isset($_SESSION['address'])
&& isset($_SESSION['website']) && isset($_SESSION['industry']) && isset($_SESSION['founded']) && isset($_SESSION['size'])) {
    header("Location: company_dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<ul class="notifications"></ul>
<div class="container">
    <h2>Company Login</h2>
    <form action="/api/company/login" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit">Login</button>
        </div>
        <div class="form-group">
            <a href="company_forgot_password.php">Forgot Password?</a>
        </div>
        <div class="form-group">
            <p>Don't have an account? <a href="company_signup.php">Sign Up</a></p>
        </div>
    </form>
</div>

<div class="container">
    <h3 style="text-align: center;">Want to apply a job?</h3>
    <a href="user_login.php"><button type="submit">For Candidates <i class="fa fa-arrow-right"></i></button></a>
</div>
<script src="js/toast.js"></script>
</body>
</html>
