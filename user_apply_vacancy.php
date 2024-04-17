<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/util.php';
require __DIR__ . '/user_util.php';
require __DIR__ . '/company_util.php';

if(!isLogged()) {
    header("Location: user_login.php");
    exit();
}

if(!isset($_GET["vacancy_id"])) {
    header("Location: user_vacancy.php");
    exit();
}
$vacancy_id = $_GET["vacancy_id"];
$vacancy = json_decode(fetchVacancyInfo($vacancy_id), associative: true)[0];

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Vacancy</title>
    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>    
	<div class="container">
        <h2>Apply for Vacancy</h2>
        <div class="tabs">
            <a href="user_dashboard.php" class="tablink">Home</a>
            <a href="user_vacancy.php" class="tablink">Vacancy</a>
            <a href="user_profile.php" class="tablink">Profile</a>
            <a href="/api/logout" class="tablink">Logout</a>
        </div>		
        <div class="vacancy-details">
            <h3><?php echo $title;?></h3>
            <p><strong>Company:</strong> <?php echo $company_name;?></p>
            <p><strong>Location:</strong> <?php echo $location;?></p>
            <p><strong>Job Description:</strong> <?php echo $description;?></p>
            <p><strong>Workplace Type:</strong> <?php echo $workplace_type;?></p>
            <p><strong>Job Type:</strong> <?php echo $job_type;?></p>
            <p><strong>Status:</strong> <?php echo $status;?></p>
        </div>
        <form action="/api/user/vacancy/apply" method="POST">
            <input type="hidden" name="user_id" value="<?php echo getSessionEmail();?>">
            <input type="hidden" name="vacancy_id" value="<?php echo $vacancy_id;?>">
            <button type="submit">Apply Now</button>
        </form>
    </div>
</body>
</html>
