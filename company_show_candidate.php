<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/util.php';
require __DIR__ . '/user_util.php';
require __DIR__ . '/company_util.php';

if(!isLogged()) {
    header("Location: company_login.php");
    exit();
}

if(!(isset($_GET['email']) && isset($_GET['vacancy_id'])))
    send400("company_profile.php", "url_is_broken");

$email = $_GET['email'];
$vacancy_id = $_GET['vacancy_id'];

$profile = json_decode(fetchUserProfile($email), associative: true)[0];
$name = $profile['name'];
$address = $profile['address'];
$about = $profile['about'];

$vacancy = json_decode(fetchVacancyInfo($vacancy_id), associative: true)[0];
$vacancy_title = $vacancy['title'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
<div class="container">
    <ul class="notifications"></ul>
    <h2>Candidate Profile</h2>
    <div class="tabs">
        <a href="company_dashboard.php" class="tablink">Home</a>
        <a href="company_vacancy.php" class="tablink">Vacancy</a>
        <a href="company_profile.php" class="tablink">Profile</a>
        <a href="/api/logout" class="tablink">Logout</a>
    </div>
    <div class="content">
        <p><strong>Name:</strong> <?php echo $name;?></p>
        <p><strong>Email:</strong> <?php echo $email;?></p>
        <strong>About:</strong>
        <p><?php echo $about;?></p>
        <p><strong>Address:</strong> <?php echo $address?></p>
    </div>

    <form action="/api/company/email/send_vacancy_approve" method="post">
        <input type="hidden" name="email" value="<?php echo $email;?>">
        <input type="hidden" name="company_name" value="<?php echo getSessionName();?>">
        <input type="hidden" name="job_title" value="<?php echo $vacancy_title;?>">
        <input type="hidden" name="vacancy_id" value="<?php echo $vacancy_id;?>">
        <button type="submit">Approve</button>
    </form>

    <a href="company_profile.php"><button>Go back to company profile</button></a>
</div>
<script src="js/toast.js"></script>
</body>
</html>


