<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/util.php';
require __DIR__ . '/user_util.php';
require __DIR__ . '/company_util.php';
require __DIR__ . '/admin_util.php';

if(!isLoggedAdmin()) {
    header("Location: company_login.php");
    exit();
}

if(!(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['location']) && isset($_POST['description'])
    && isset($_POST['workplace_type']) && isset($_POST['job_type']) && isset($_POST['status'])))
    send400("admin_dashboard.php", "url_is_broken");

$id = $_POST['id'];
$title = $_POST['title'];
$location = $_POST['location'];
$description = $_POST['description'];
$workplace_type = $_POST['workplace_type'];
$job_type = $_POST['job_type'];
$status = $_POST['status'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vacancy</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
<ul class="notifications"></ul>
<div class="container">
    <h2>Edit Vacancy</h2>
    <div class="tabs">
        <a href="admin_dashboard.php" class="tablink">Dashboard</a>
        <a href="/api/logout" class="tablink">Logout</a>
    </div>
    <form action="/api/admin/vacancy/update" method="post">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $title;?>" required>
        <br><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo $location;?>" required>
        <br><br>

        <label for="description">Description (max 10000 characters):</label>
        <textarea id="description" name="description" rows="10" cols="105" maxlength="10000"><?php echo $description;?></textarea>
        <br><br>

        <label for="workplace_type">Workplace Type:</label>
        <select name="workplace_type" id="workplace_type">
            <option value="On-site" <?php echo ($workplace_type == "On-site" ? "selected" : "") ?>>On-site</option>
            <option value="Hybrid" <?php echo ($workplace_type == "Hybrid" ? "selected" : "") ?>>Hybrid</option>
            <option value="Remote" <?php echo ($workplace_type == "Remote" ? "selected" : "") ?>>Remote</option>
        </select>
        <br><br>

        <label for="job_type">Job Type:</label>
        <select name="job_type" id="job_type">
            <option value="Full-time" <?php echo ($job_type == "Full-time" ? "selected" : "") ?>>Full-time</option>
            <option value="Contract" <?php echo ($job_type == "Contract" ? "selected" : "") ?>>Contract</option>
            <option value="Volunteer" <?php echo ($job_type == "Volunteer" ? "selected" : "") ?>>Volunteer</option>
            <option value="Part-time" <?php echo ($job_type == "Part-time" ? "selected" : "") ?>>Part-time</option>
            <option value="Temporary" <?php echo ($job_type == "Temporary" ? "selected" : "") ?>>Temporary</option>
            <option value="Internship" <?php echo ($job_type == "Internship" ? "selected" : "") ?>>Internship</option>
            <option value="Other" <?php echo ($job_type == "Other" ? "selected" : "") ?>>Other</option>
        </select>
        <br><br>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="Open" <?php echo ($status == "Open" ? "selected" : "") ?>>Open</option>
            <option value="Close" <?php echo ($status == "Close" ? "selected" : "") ?>>Close</option>
        </select>
        <br><br>

        <button type="submit">Save Changes</button>
    </form>
    <form action='/api/admin/vacancy/remove' method='post'>
        <input type='hidden' name='id' value='<?php echo $id;?>'>
        <button type='submit' class=\"delete-btn\">Delete</button>
    </form>
</div>
</body>
</html>
