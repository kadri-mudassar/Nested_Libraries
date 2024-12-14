<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Navbar Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * {
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            margin: 0;
            padding: 40px;
            background-color: var(--secondary-color);
            font-family: "Poppins", sans-serif;
        }

        header {
            width: 100%;
            background: var(--white);
            color: var(--text-color);
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: var(--max-width);
            margin: auto;
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            box-shadow: 0 0 10px #089da1;
        }

        .logo img {
            height: 60px; /* Increased logo size */
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 2rem; /* Increased gap for better spacing */
        }

        nav a {
            color: var(--text-color);
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            font-size: 1.5rem; /* Increased font size */
            border-radius: 4px;
            transition: background 0.3s, color 0.3s;
        }

        nav a:hover {
            color: var(--white);
            background: var(--primary-color);
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background: var(--white);
            min-width: 150px;
            border-radius: 4px;
            z-index: 100;
            box-shadow: 089da1;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px;
            font-size: 1.3rem; /* Slightly increased font size for dropdown */
            color: var(--text-color);
        }

        .dropdown-menu a:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        /* Mobile Styles */
        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem; /* Increased size for mobile menu icon */
        }

        @media (max-width: 768px) {
            nav ul {
                display: none;
                flex-direction: column;
                width: 100%;
                position: absolute;
                top: 100%;
                left: 0;
                background: var(--white);
                border-radius: 4px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            nav ul.active {
                display: flex;
            }

            .menu-toggle {
                display: block;
            }

            nav a {
                padding: 1rem;
                font-size: 1.5rem; /* Increased font size for mobile */
                text-align: center;
            }
        }

        .container {
            max-width: var(--max-width);
            margin: auto;
            text-align: center;
            padding: 1rem;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="assets/img/logo.png" alt="Logo"> <!-- Replace with your logo path -->
    </div>
    <div class="menu-toggle" id="mobile-menu">
        <i class="fa fa-bars"></i> <!-- Hamburger icon -->
    </div>
    <nav>
        <ul id="nav-list">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="issued-books.php">Issued Books</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Account <i class="fa fa-angle-down"></i></a>
                <div class="dropdown-menu">
                    <a href="my-profile.php">My Profile</a>
                    <a href="change-password.php">Change Password</a>
                </div>
            </li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
</header>

<script>
    const mobileMenu = document.getElementById('mobile-menu');
    const navList = document.getElementById('nav-list');

    mobileMenu.addEventListener('click', () => {
        navList.classList.toggle('active'); // Toggle the active class
    });
</script>

</body>
</html>
