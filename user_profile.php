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
			
			<br><br>
            <h3>Applied Vacancies</h3>
            <ul>
                <?php
                    $vacancies = json_decode(fetchUserApply(getSessionEmail()), associative: true);
                    foreach($vacancies as $vacancy) {
                        $id = $vacancy["id"];
                        $title = $vacancy["title"];
                        $location = $vacancy["location"];
                        $description = $vacancy["description"];
                        $workplace_type = $vacancy["workplace_type"];
                        $job_type = $vacancy["job_type"];
                        $status = $vacancy["status"];
                        $company_id = $vacancy["company_id"];

                        $company = json_decode(fetchCompanyInfo($company_id), associative: true)[0];
                        $company_name = $company['name'];

                        echo "<li>
                            <p><strong>Title:</strong> $title</p>
                            <p><strong>Company:</strong> $company_name</p>
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
