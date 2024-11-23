<?php include "config/db.php"?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/font-awesome/css/all.css">
    <script src="https://kit.fontawesome.com/bad2460ef5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body>
    <?php include "includes/header.php"?>
    <section class="home" id="home">
    <div>
        <img src="assets/img/landing-page.png">
    </div>
    <div class="container">
        <span>
            <h1>Trusted car marketplace</h1>
            <br>
        </span>
        <span>
            <p>Lorem ipsum dolor sit amet consectetur 
                <br>adipisicing elit. Illum voluptatem nobis officia. <br>
                In a accusamus pariatur consequuntur natus!<br>
            </p>
        </span>
            <a href="frontend/login.php" target="_blank"><button id="get-started-btn">Get Started</button></a>
        <span>
            <a href="frontend/register.php" target="_blank"><button id="sign-up-btn">Sign Up</button></a>
        </span>
    </div>
    </section>
    <section class="about" id="about" style="background-image: url(assets/img/supra.gif); background-position: center;
    background-size: cover;
    background-repeat: no-repeat;">
        <div>
            <h1><span style="color: red;">Hi</span>, Welcome to Car Marketplace</h1>
            <h2 id="about">
                <span style="color: red; text-decoration: underline; font-size:2em;">ABOUT</span>
                <span style="font-size: 2em; margin-left: 10px;">US</span>
            </h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <div class="car-brand">
                <img src="assets/img/toyota-logo.png">
                <img src="assets/img/honda-logo.png">
                <img src="assets/img/mitsubishi-logo.png">
            </div>
            <div class="brand-name">
                <div>
                    <h2>TOYOTA</h2>
                </div>
                <div>
                    <h2>HONDA</h2>
                </div>
                <div>
                    <h2>MITSUBISHI</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="contact" id="contact">
        <div class="contact-container">
            <h1><span style="color: red;">Contact</span> Us</h1>
            <br><br>
            <p>Need to get in touch with us? Fill out the form and submit your details.</p>
            <p>We will get back to you as soon as possible.</p>
        </div>
        <div class="form-container">
            <form id="contact-form" action="backend/contactus.php" method="POST">
                <div class="form-group">
                    <label for="first-name">First name <span>*</span></label>
                    <input type="text" id="first-name" name="first_name" required>
                </div>

                <div class="form-group">
                    <label for="last-name">Last name <span>*</span></label>
                    <input type="text" id="last-name" name="last_name">
                </div>

                <div class="form-group full-width">
                    <label for="email">Email <span>*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group full-width">
                    <label for="message">What can we help you with? <span>*</span></label>
                    <textarea id="message" name="message" required></textarea>
                </div>

                <button type="submit" class="submit-button" name="submit">Submit</button>
            </form>
        </div>
    </section>
        
    <?php include "includes/footer.php"?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('contact-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Collect form data
            const formData = new FormData(this);

            // Send form data using fetch API
            fetch('backend/contactus.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // Handle response as text
            .then(result => {
                // Display success alert
                Swal.fire({
                    title: 'Success!',
                    text: 'Message sent successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                document.getElementById('contact-form').reset();
            })
            .catch(error => {
                // Display error alert
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue sending your message. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>


    <script>
        let section = document.querySelectorAll('section');
        let navLinks = document.querySelectorAll('header nav a');

        window.onscroll = () => {
            section.forEach(sec => {
                let top = window.scrollY;
                let offset = sec.offsetTop - 150;
                let height = sec.offsetHeight;
                let id = sec.getAttribute('id');

                if(top >= offset && top < offset + height) {
                    navLinks.forEach(links => {
                        links.classList.remove('active');
                        document.querySelector('header nav a[href*=' + id + ']').classList.add('active');
                    });
                };
            });
        };
    </script>
    <script>
        window.addEventListener("scroll", function() {
            var header = document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY > 0);
        })
    </script>
</body>
</html>
