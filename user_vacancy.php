<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/util.php';
require __DIR__ . '/user_util.php';
require __DIR__ . '/company_util.php';

if(!isLogged()) {
    header("Location: user_login.php");
    exit();
}

$searchKeyword = "";
if(isset($_GET['search']))
    $searchKeyword = $_GET['search'];
$vacancies = json_decode(fetchAllVacancy($searchKeyword), true)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacancy</title>
    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
    <div class="container">
        <h2>Vacancy</h2>
        <div class="tabs">
            <a href="user_dashboard.php" class="tablink">Home</a>
            <a href="user_vacancy.php" class="tablink">Vacancy</a>
            <a href="user_profile.php" class="tablink">Profile</a>
            <a href="/api/logout" class="tablink">Logout</a>
        </div>
        <div class="vacancy-list">

            <?php
            $vacancies = json_decode(fetchAllVacancy($searchKeyword), associative: true);
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
                    <p>$description</p>
                    <a href=\"user_apply_vacancy.php?vacancy_id=$id\" class=\"show-more\">Show More</a>
                </div>
            </div>
			<br>";
            }


            ?>

            <!-- Vacancy 1 -->

            <!-- Vacancy 2 -->
            <div class="vacancy">
                <div class="vacancy-info">
                    <h3>Marketing Intern</h3>
                    <p>Explore the world of marketing with Company 2 as a Marketing Intern. Work on exciting projects and gain valuable insights into digital marketing strategies.</p>
                    <a href="marketingapply.html" class="show-more">Show More</a>
                </div>
            </div>
			<br>
            <!-- Vacancy 3 -->
            <div class="vacancy">
                <div class="vacancy-info">
                    <h3>Graphic Design Intern</h3>
                    <p>Unleash your creativity with Company 3 as a Graphic Design Intern. Create stunning visual content and contribute to exciting design projects.</p>
                    <a href="graphicapply.html" class="show-more">Show More</a>
                </div>
            </div>

            <!-- Add more vacancies here -->
        </div>
    </div>
</body>
</html>

