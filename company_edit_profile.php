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
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <div class="tabs">
            <a href="company_dashboard.php" class="tablink">Home</a>
            <a href="company_vacancy.php" class="tablink">Vacancy</a>
            <a href="company_profile.php" class="tablink">Profile</a>
            <a href="/api/logout" class="tablink">Logout</a>
        </div>
        <form action="/api/company/account/update" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo getSessionName();?>" required>
            <br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo getSessionEmail();?>" required disabled>
            <br><br>

            <label for="about">About (max 10000 characters):</label>
            <textarea id="about" name="about" rows="5" cols="105" maxlength="10000"><?php echo getSessionAbout();?></textarea>
            <br><br>

            <label for="address">Address:</label>
            <input type="text" id="address" value="<?php echo getSessionAddress();?>" name="address">
            <br><br>

            <label for="website">Website:</label>
            <input type="text" id="website" value="<?php echo getSessionWebsite();?>" name="website">
            <br><br>

            <label for="industry">Industry:</label>
            <input type="text" id="industry" value="<?php echo getSessionIndustry();?>" name="industry">
            <br><br>

            <label for="founded">Founded:</label>
            <input type="text" id="founded" value="<?php echo getSessionFounded();?>" name="founded">
            <br><br>

            <label for="size">Size:</label>
            <input type="text" id="size" value="<?php echo getSessionSize();?>" name="size">
            <br><br>


            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
