<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/util.php';
require __DIR__ . '/user_util.php';
require __DIR__ . '/company_util.php';

if(!isLogged()) {
    header("Location: company_login.php");
    exit();
}

$searchKeyword = "";
if(isset($_GET['search']))
    $searchKeyword = $_GET['search'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacancy</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
<ul class="notifications"></ul>
<div class="container">
    <h2>Created Vacancy</h2>
    <div class="tabs">
        <a href="company_dashboard.php" class="tablink">Home</a>
        <a href="company_vacancy.php" class="tablink">Vacancy</a>
        <a href="company_profile.php" class="tablink">Profile</a>
        <a href="/api/logout" class="tablink">Logout</a>
    </div>
    <div class="vacancy-list">
        <p style="text-align: right">
            <a href="company_add_vacancy.php"><button>Add Vacancy</button></a>
        </p>
        <?php
        $vacancies = json_decode(fetchCompanyVacancy(getSessionEmail(), $searchKeyword), associative: true);
        foreach($vacancies as $vacancy) {
            $id = $vacancy["id"];
            $title = $vacancy["title"];
            $location = $vacancy["location"];
            $description = $vacancy["description"];
            $workplace_type = $vacancy["workplace_type"];
            $job_type = $vacancy["job_type"];
            $status = $vacancy["status"];
            $company_id = $vacancy["company_id"];

            echo "<div class=\"vacancy\">
                <div class=\"vacancy-info\">
                    <h3>$title</h3>
                    <p>$location | $workplace_type | $job_type</p>
                    <form action='company_edit_vacancy.php' method='post'>
                        <input type='hidden' name='id' value='$id'>
                        <input type='hidden' name='title' value='$title'>
                        <input type='hidden' name='location' value='$location'>
                        <input type='hidden' name='description' value='$description'>
                        <input type='hidden' name='workplace_type' value='$workplace_type'>
                        <input type='hidden' name='job_type' value='$job_type'>
                        <input type='hidden' name='status' value='$status'>
                        <button type='submit'>Edit</button>
                    </form>
                    <form action='/api/company/vacancy/remove' method='post'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit'>Delete</button>
                    </form>
                </div>
            </div>
			<br>";
        }
        ?>

        <!-- Add more vacancies here -->
    </div>
</div>
<script src="js/toast.js"></script>
</body>
</html>

