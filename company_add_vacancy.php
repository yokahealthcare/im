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
    <title>Add Vacancy</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
<div class="container">
    <ul class="notifications"></ul>
    <h2>Add Vacancy</h2>
    <div class="tabs">
        <a href="company_dashboard.php" class="tablink">Home</a>
        <a href="company_vacancy.php" class="tablink">Vacancy</a>
        <a href="company_profile.php" class="tablink">Profile</a>
        <a href="/api/logout" class="tablink">Logout</a>
    </div>
    <form action="/api/company/vacancy/create" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
        <br><br>

        <label for="description">Description (max 10000 characters):</label><br><br>
        <textarea id="description" name="description" rows="10" cols="105" maxlength="10000"></textarea>
        <br><br>

        <label for="workplace_type">Workplace Type:</label>
        <select name="workplace_type">
            <option value="On-site">On-site</option>
            <option value="Hybrid">Hybrid</option>
            <option value="Remote">Remote</option>
        </select>
        <br><br>

        <label for="job_type">Job Type:</label>
        <select name="job_type">
            <option value="Full-time">Full-time</option>
            <option value="Contract">Contract</option>
            <option value="Volunteer">Volunteer</option>
            <option value="Part-time">Part-time</option>
            <option value="Temporary">Temporary</option>
            <option value="Internship">Internship</option>
            <option value="Other">Other</option>
        </select>
        <br><br>

        <label for="status">Status:</label>
        <select name="status">
            <option value="Open">Open</option>
            <option value="Close">Close</option>
        </select>

        <input type="hidden" name="company_id" value="<?php echo getSessionEmail();?>">
        <br><br><br>

        <button type="submit">Create new vacancy</button>
    </form>
</div>
<script src="js/toast.js"></script>
</body>
</html>
