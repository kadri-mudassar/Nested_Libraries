<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        section {
            width: 100%;
            height: 100vh;
            background-image: url(image/bg.png);
            background-size: cover;
            background-position: center;
        }

        section nav {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between; /* Use space-between to align logo and button */
            box-shadow: 0 0 10px #089da1;
            background: #fff;
            position: fixed;
            left: 0;
            z-index: 100;
            padding: 0 20px; /* Optional padding */
        }

        section nav .logo {
            margin-right: auto; /* Ensure logo is on the left */
        }

        section nav .logo img {
            width: 280px;
            cursor: pointer;
            margin: 8px 0; 
        }

        section nav .login-btn {
            margin-left: auto; /* Push the login button to the right */
        }

        section nav .login-btn .btn {
            text-decoration: none;
            color: #fff;
            background-color: #089da1; /* Button color */
            padding: 10px 20px; /* Padding for the button */
            border-radius: 5px; /* Rounded corners */
        }

        section nav .login-btn .btn:hover {
            background-color: #067a84; /* Darker shade on hover */
        }

        section .main {
            display: flex;
            align-items: center;
            justify-content: space-around;
            position: relative;
            top: 10%;
        }

        section .main h1 {
            position: relative;
            font-size: 55px;
            top: 80px;
            left: 25px;
        }

        section .main h1 span {
            color: #089da1;
        }

        section .main p {
            width: 650px;
            text-align: justify;
            line-height: 22px;
            position: relative;
            top: 125px;
            left: 25px;
        }

        section .main .main_tag .main_btn {
            background: #089da1;
            padding: 10px 20px;
            position: relative;
            top: 200px;
            left: 25px;
            color: #fff;
            text-decoration: none;
        }

        section .main .main_img img {
            width: 780px;
            position: relative;
            top: 90px;
            left: 20px;
        }

        /* Services */
        .services {
            width: 100%;
            height: auto;
            margin: 35px 0;
        }

        .services .services_box {
            width: 95%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .services .services_box .services_card {
            text-align: center;
            width: 310px;
            height: auto;
            box-shadow: 0 0 8px #089da1;
            padding: 15px 10px;
        }

        .services .services_box .services_card i {
            color: #089da1;
            font-size: 45px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .services .services_box .services_card h3 {
            margin-bottom: 10px;
        }

        /* About */
        .about {
            width: 100%;
            height: auto;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .about .about_image img {
            width: 800px;
        }

        .about .about_tag h1 {
            font-size: 50px;
            position: relative;
            bottom: 35px;
        }

        .about .about_tag p {
            line-height: 22px;
            width: 650px;
            text-align: justify;
            margin-bottom: 15px;
        }

        .about .about_tag .about_btn {
            padding: 10px 20px;
            background: #089da1;
            color: #fff;
            text-decoration: none;
            position: relative;
            top: 50px;
        }
    </style>
</head>
<body>
    <section>
        <nav>
            <div class="logo">
                <img src="assets/img/logo.png" alt="Logo">
            </div>
            <div class="login-btn">
                <a href="login.php" class="btn">Login</a>
            </div>
        </nav>

        <div class="main">
            <div class="main_tag">
                <h1>WELCOME TO<br><span>THE READING NEST</span></h1>
                <p>
                Welcome to The Reading Nest Library! 🌟 Dive into a world of 
                imagination and knowledge,where every book opens a new door. 
                Join us on this literary journey and discover the 
                joy of reading! 📚✨
                </p>
                <a href="#" class="main_btn">Learn More</a>
            </div>

            <div class="main_img">
                <img src="image/table.png" alt="Table Image">
            </div>
        </div>
    </section>


    <div class="about">
        <div class="about_image">
            <img src="image/about.png" alt="About Us Image">
        </div>
        <div class="about_tag">
            <h1>About Us</h1>
            <p>
             The Reading Nest Library is a welcoming haven for book lovers of all ages.
             Our mission is to inspire a passion for reading and learning through a diverse 
             collection of books and engaging programs. We strive to create a community space 
             where everyone can explore, discover, and connect through literature.
            </p>
            <a href="#" class="about_btn">Learn More</a>
        </div>
    </div>
</body>
</html>
