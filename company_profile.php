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
    <title>Profile</title>
    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
<div class="container">
    <h2>Profile</h2>
    <div class="tabs">
        <a href="company_dashboard.php" class="tablink">Home</a>
        <a href="company_vacancy.php" class="tablink">Vacancy</a>
        <a href="company_profile.php" class="tablink">Profile</a>
        <a href="/api/logout" class="tablink">Logout</a>
    </div>
    <div class="profile-info">
        <!-- Display user's profile information -->
        <h3>Company Information</h3>
        <p><strong>Name:</strong> <?php echo getSessionName();?></p>
        <p><strong>Email:</strong> <?php echo getSessionEmail();?></p>
        <p><strong>About:</strong> <?php echo getSessionAbout();?></p>
        <p><strong>Address:</strong> <?php echo getSessionAddress();?></p>
        <p><strong>Website:</strong> <?php echo getSessionWebsite();?></p>
        <p><strong>Industry:</strong> <?php echo getSessionIndustry();?></p>
        <p><strong>Founded:</strong> <?php echo getSessionFounded();?></p>
        <p><strong>Size:</strong> <?php echo getSessionSize();?></p>

        <a href="company_edit_profile.php" class="edit-btn">Edit Profile</a>

        <br><br>
        <h3>List of Cadidates Applied Vacancies</h3>
        <ul>
            <?php
            $vacancies = json_decode(fetchCompanyApply(getSessionEmail()), associative: true);
            foreach($vacancies as $vacancy) {

                echo "<li>
                            <p><strong>Title:</strong> $title</p>
                            <p><strong>User</strong> $company_name</p>
                            <form action='/api/user/vacancy/remove' method='post'>
                                <input type='hidden' name='vacancy_id' value='$id'>
                                <button type='submit' class=\"delete-btn\">Delete</button>
                            </form>
                        </li>";
            }


            ?>
        </ul>
    </div>
</div>
</body>
</html>
