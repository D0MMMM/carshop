<?php 
include "../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/register.css">
    <title>Register an account</title>
</head>
<body>
    <div class="register">
    <h1>Register an account <span style="color: red;">*</span></h1>
        <form action="../backend/register.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="contact" name="contact" placeholder="Contact number" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirmpassword" placeholder="Confirm password" required>
            <input type="submit" value="Register" name="register">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ff0000" fill-opacity="1" d="M0,160L30,181.3C60,203,120,245,180,240C240,235,300,181,360,154.7C420,128,480,128,540,138.7C600,149,660,171,720,192C780,213,840,235,900,250.7C960,267,1020,277,1080,245.3C1140,213,1200,139,1260,106.7C1320,75,1380,85,1410,90.7L1440,96L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path>
    </svg>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get("error");

            if (error === "email_exists") {
                alert("This email already exists!");
            } else if (error === "password_mismatch") {
                alert("Passwords do not match!");
            }
        });
    </script>
</body>
</html>