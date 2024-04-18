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
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
<ul class="notifications"></ul>
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
        <strong>About:</strong>
        <p><?php echo getSessionAbout();?></p>
        <p><strong>Address:</strong> <?php echo getSessionAddress();?></p>
        <p><strong>Website:</strong> <?php echo getSessionWebsite();?></p>
        <p><strong>Industry:</strong> <?php echo getSessionIndustry();?></p>
        <p><strong>Founded:</strong> <?php echo getSessionFounded();?></p>
        <p><strong>Size:</strong> <?php echo getSessionSize();?></p>

        <a href="company_edit_profile.php" class="edit-btn"><button>Edit Profile</button></a>

        <br><br>
        <h2>List of Cadidates Applied Vacancies</h2>
        <ul>
            <?php
            $vacancies = json_decode(fetchCompanyVacancy(getSessionEmail()), associative: true);
            foreach($vacancies as $vacancy) {
                $id = $vacancy['id'];
                $title = $vacancy['title'];
                $location = $vacancy['location'];
                $description = $vacancy['description'];
                $workplace_type = $vacancy['workplace_type'];
                $job_type = $vacancy['job_type'];
                $status = $vacancy['status'];

                echo "<li>";
                    echo "<b>$title</b>";
                    echo "<ul>";
                    $applies = json_decode(fetchCompanyApply($id), associative: true);
                    foreach ($applies as $apply) {
                        $user_id = $apply['user_id'];
                        $user = json_decode(fetchUserProfile($user_id), associative: true)[0];

                        $email = $user['email'];
                        $name = $user['name'];

                        echo "<li>$email | $name (<a href='company_show_candidate.php?email=$email&vacancy_id=$id'>Bio</a>)</li>";


                    }
                    echo "</ul>";
                echo "</li><br><br>";
            }

            ?>
        </ul>
    </div>
</div>
<script src="js/toast.js"></script>
</body>
</html>
