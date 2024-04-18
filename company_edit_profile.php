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
    <title>Edit Profile</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/mainstyles.css">
</head>
<body>
    <ul class="notifications"></ul>
    <div class="container">
        <h2>Edit Profile</h2>
        <div class="tabs">
            <a href="company_dashboard.php" class="tablink">Home</a>
            <a href="company_vacancy.php" class="tablink">Vacancy</a>
            <a href="company_profile.php" class="tablink">Profile</a>
            <a href="/api/logout" class="tablink">Logout</a>
        </div>
        <form action="/api/company/account/update" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo getSessionName();?>" required>
            <br><br>

            <input type="hidden" name="email" value="<?php echo getSessionEmail();?>">

            <label for="about">About (max 10000 characters):</label>
            <textarea id="about" name="about" rows="5" cols="105" maxlength="10000"><?php echo getSessionAbout();?></textarea>
            <br><br>

            <label for="address">Address:</label>
            <input type="text" id="address" value="<?php echo getSessionAddress();?>" name="address">
            <br><br>

            <label for="website">Website:</label>
            <input type="text" id="website" value="<?php echo getSessionWebsite();?>" name="website">
            <br><br>

            <label for="industry">Industry:</label>
            <select name="industry" id="industry">
                <?php $t = getSessionIndustry();?>
                <option value="Agriculture" <?php echo ($t == "Agriculture" ? "selected" : "") ?>>Agriculture</option>
                <option value="Arts" <?php echo ($t == "Arts" ? "selected" : "") ?>>Arts</option>
                <option value="Construction" <?php echo ($t == "Construction" ? "selected" : "") ?>>Construction</option>
                <option value="Consumer_goods" <?php echo ($t == "Consumer_goods" ? "selected" : "") ?>>Consumer Goods</option>
                <option value="Corporate_services" <?php echo ($t == "Corporate_services" ? "selected" : "") ?>>Corporate Services</option>
                <option value="Design" <?php echo ($t == "Design" ? "selected" : "") ?>>Design</option>
                <option value="Education" <?php echo ($t == "Education" ? "selected" : "") ?>>Education</option>
                <option value="Energy_mining" <?php echo ($t == "Energy_mining" ? "selected" : "") ?>>Energy & Mining</option>
                <option value="Entertainment" <?php echo ($t == "Entertainment" ? "selected" : "") ?>>Entertainment</option>
                <option value="Finance" <?php echo ($t == "Finance" ? "selected" : "") ?>>Finance</option>
                <option value="Hardware_networking" <?php echo ($t == "Hardware_networking" ? "selected" : "") ?>>Hardware & Networking</option>
                <option value="Health_care" <?php echo ($t == "Health_care" ? "selected" : "") ?>>Health Care</option>
                <option value="Legal" <?php echo ($t == "Legal" ? "selected" : "") ?>>Legal</option>
                <option value="Manufacturing" <?php echo ($t == "Manufacturing" ? "selected" : "") ?>>Manufacturing</option>
                <option value="Media_communications" <?php echo ($t == "Media_communications" ? "selected" : "") ?>>Media & Communications</option>
                <option value="Nonprofit" <?php echo ($t == "Nonprofit" ? "selected" : "") ?>>Nonprofit</option>
                <option value="Public_administration" <?php echo ($t == "Public_administration" ? "selected" : "") ?>>Public Administration</option>
                <option value="Public_safety" <?php echo ($t == "Public_safety" ? "selected" : "") ?>>Public Safety</option>
                <option value="Real_estate" <?php echo ($t == "Real_estate" ? "selected" : "") ?>>Real Estate</option>
                <option value="Recreation_travel" <?php echo ($t == "Recreation_travel" ? "selected" : "") ?>>Recreation & Travel</option>
                <option value="Retail" <?php echo ($t == "Retail" ? "selected" : "") ?>>Retail</option>
                <option value="Software_it_services" <?php echo ($t == "Software_it_services" ? "selected" : "") ?>>Software & IT Services</option>
                <option value="Transportation_logistics" <?php echo ($t == "Transportation_logistics" ? "selected" : "") ?>>Transportation & Logistics</option>
                <option value="Wellness_fitness" <?php echo ($t == "Wellness_fitness" ? "selected" : "") ?>>Wellness & Fitness</option>
            </select>
            <br><br>

            <label for="founded">Founded:</label>
            <select name="founded" id="founded"></select>
            <br><br>

            <label for="size">Size:</label>
            <select name="size" id="size">
                <?php $t = getSessionSize();?>
                <option value="0-10" <?php echo ($t == "0-10" ? "selected" : "") ?>>0-10</option>
                <option value="11-50" <?php echo ($t == "11-50" ? "selected" : "") ?>>11-50</option>
                <option value="51-200" <?php echo ($t == "51-200" ? "selected" : "") ?>>51-200</option>
                <option value="201-1000" <?php echo ($t == "201-1000" ? "selected" : "") ?>>201-1000</option>
                <option value="1000+" <?php echo ($t == "1000+" ? "selected" : "") ?>>1000+</option>
            </select>
            <br><br>


            <button type="submit">Save Changes</button>
        </form>
    </div>

    <script>
        const yearDropdown = document.getElementById("founded");
        const currentYear = new Date().getFullYear();

        for (let year = currentYear - 100; year <= currentYear; year++) {
            const option = document.createElement("option");
            option.value = year;
            option.innerHTML = year;
            // Select 2002 if it matches the current year in the loop
            option.selected = year === <?php echo getSessionFounded();?>;
            yearDropdown.appendChild(option);
        }

    </script>
    <script src="js/toast.js"></script>
</body>
</html>
