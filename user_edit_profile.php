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
    <title>Edit Profile</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
    <ul class="notifications"></ul>
    <div class="container">
        <h2>Edit Profile</h2>
        <div class="tabs">
            <a href="user_dashboard.php" class="tablink">Home</a>
            <a href="user_vacancy.php" class="tablink">Vacancy</a>
            <a href="user_profile.php" class="tablink">Profile</a>
            <a href="/api/logout" class="tablink">Logout</a>
        </div>				
        <form action="/api/user/account/update" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo getSessionName();?>" required>
			<br><br>

            <input type="hidden" name="email" value="<?php echo getSessionEmail();?>">

            <label for="address">Address:</label>
            <input type="text" id="address" value="<?php echo getSessionAddress();?>" name="address">
			<br><br>

            <label for="about">About (max 10000 characters):</label>
            <textarea id="about" name="about" rows="5" cols="105" maxlength="10000"><?php echo getSessionAbout();?></textarea>
			<br><br>

            <button type="submit">Save Changes</button>
        </form>
    </div>
    <script src="js/toast.js"></script>
</body>
</html>
