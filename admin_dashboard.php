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
    <div class="tabs">
        <a href="admin_dashboard.php" class="tablink">Dashboard</a>
        <a href="/api/logout" class="tablink">Logout</a>
    </div>

    <h3>List all vacancies</h3>
    <ul>
        <?php
        $vacancies = json_decode(fetchAllVacancy(literal_all: true), associative: true);
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
                    <p><b>$title</b></p>
                    <p>$company_name | $location | $workplace_type | $job_type | $status</p>
                    <form action='admin_edit.php' method='post'>
                        <input type='hidden' name='id' value='$id'>
                        <input type='hidden' name='title' value='$title'>
                        <input type='hidden' name='location' value='$location'>
                        <input type='hidden' name='description' value='$description'>
                        <input type='hidden' name='workplace_type' value='$workplace_type'>
                        <input type='hidden' name='job_type' value='$job_type'>
                        <input type='hidden' name='status' value='$status'>
                        <button type='submit'>Edit</button>
                    </form>
                </li>";
        }
        ?>
    </ul>
</div>
<script src="js/toast.js"></script>
</body>
</html>


