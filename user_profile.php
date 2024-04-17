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
    <title>Profile</title>
    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
    <div class="container">
        <h2>Profile</h2>
        <div class="tabs">
            <a href="user_dashboard.php" class="tablink">Home</a>
            <a href="user_vacancy.php" class="tablink">Vacancy</a>
            <a href="user_profile.php" class="tablink">Profile</a>
            <a href="/api/logout" class="tablink">Logout</a>
        </div>		
        <div class="profile-info">
            <!-- Display user's profile information -->
            <h3>User Information</h3>
            <p><strong>Name:</strong> <?php echo getSessionName();?></p>
            <p><strong>Email:</strong> <?php echo getSessionEmail();?></p>
			<p><strong>About Me:</strong> <?php echo getSessionAbout();?></p>
            <p><strong>Address:</strong> <?php echo getSessionAddress()?></p>

             <a href="user_edit_profile.php" class="edit-btn">Edit Profile</a>
			
			<!-- List of applied vacancies -->
            <h3>Applied Vacancies</h3>
            <ul>
                <?php
                    $vacancies = json_decode(fetchUserApply(getSessionEmail()), associative: true);
                    foreach($vacancies as $vacancy) {
                        echo "<li>
                            <p><strong>Title:</strong> Software Developer Intern</p>
                            <p><strong>Company:</strong> Company A</p>
                            <button class=\"delete-btn\">Delete</button>
                        </li>";
                    }


                ?>


                <!-- Add more applied vacancies here -->
            </ul>

            <!-- List of added vacancies -->
            <h3>Added Vacancies</h3>
            <ul>
                <li>
                    <p><strong>Title:</strong> Marketing Intern</p>
                    <p><strong>Company:</strong> Company B</p>
                    <!-- Add more information about the added vacancy -->
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </li>
                <!-- Add more added vacancies here -->
            </ul>
        </div>
    </div>
</body>
</html>
