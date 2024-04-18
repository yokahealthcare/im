<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Font Awesome CDN link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/toast.css">

    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<ul class="notifications"></ul>
<div class="container">
    <h2>Company Sign Up</h2>
    <form action="/api/company/signup" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="industry">Industry:</label>
            <select name="industry" id="industry">
                <option value="Agriculture">Agriculture</option>
                <option value="Arts">Arts</option>
                <option value="Construction">Construction</option>
                <option value="Consumer_goods">Consumer Goods</option>
                <option value="Corporate_services">Corporate Services</option>
                <option value="Design">Design</option>
                <option value="Education">Education</option>
                <option value="Energy_mining">Energy & Mining</option>
                <option value="Entertainment">Entertainment</option>
                <option value="Finance">Finance</option>
                <option value="Hardware_networking">Hardware & Networking</option>
                <option value="Health_care">Health Care</option>
                <option value="Legal">Legal</option>
                <option value="Manufacturing">Manufacturing</option>
                <option value="Media_communications">Media & Communications</option>
                <option value="Nonprofit">Nonprofit</option>
                <option value="Public_administration">Public Administration</option>
                <option value="Public_safety">Public Safety</option>
                <option value="Real_estate">Real Estate</option>
                <option value="Recreation_travel">Recreation & Travel</option>
                <option value="Retail">Retail</option>
                <option value="Software_it_services">Software & IT Services</option>
                <option value="Transportation_logistics">Transportation & Logistics</option>
                <option value="Wellness_fitness">Wellness & Fitness</option>
            </select>
        </div>
        <div class="form-group">
            <label for="founded">Founded:</label>
            <select name="founded" id="founded"></select>
        </div>
        <div class="form-group">
            <label for="size">Size of employees:</label>
            <select name="size" id="size">
                <option value="0-10">0-10</option>
                <option value="11-50">11-50</option>
                <option value="51-200">51-200</option>
                <option value="201-1000">201-1000</option>
                <option value="1000+">1000+</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit">Sign Up</button>
        </div>

        <div class="form-group">
            <p>Already have an account? <a href="company_login.php">Login</a></p>
        </div>
    </form>
    <script>
        const yearDropdown = document.getElementById("founded");
        const currentYear = new Date().getFullYear();

        for (let year = currentYear - 100; year <= currentYear; year++) {
            const option = document.createElement("option");
            option.value = year;
            option.innerHTML = year;
            if (year === currentYear) {
                option.selected = true;
            }
            yearDropdown.appendChild(option);
        }

    </script>
</div>
<script src="js/toast.js"></script>
</body>
</html>
