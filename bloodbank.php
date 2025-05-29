<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url('https://wallpapercave.com/wp/wp7898683.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
            color: white;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 0;
        }

        .top-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 10px;
            padding: 20px;
            position: relative;
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .btn {
            padding: 10px 20px;
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .btn:hover {
            transform: scale(1.05);
            background: linear-gradient(45deg, #ff4b2b, #ff416c);
        }

        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 80px 20px 40px;
            position: relative;
            z-index: 1;
        }

        h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: #00ffd0;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
        }

        p {
            font-size: 18px;
            margin-bottom: 40px;
            max-width: 700px;
            color: #ffffff;
        }

        .features {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .feature-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            width: 280px;
            box-shadow: 0 0 12px rgba(0,0,0,0.5);
            transition: transform 0.3s;
        }

        .feature-box:hover {
            transform: scale(1.05);
        }

        .feature-box h3 {
            color: #ffcc00;
            margin-bottom: 10px;
        }

        .feature-box p {
            font-size: 15px;
            color: #eee;
        }

        footer {
            text-align: center;
            margin-top: 50px;
            font-size: 14px;
            color: #ddd;
            position: relative;
            z-index: 1;
        }

        @media screen and (max-width: 600px) {
            h1 {
                font-size: 36px;
            }

            p {
                font-size: 16px;
            }

            .btn {
                padding: 10px;
                font-size: 13px;
            }

            .feature-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="top-nav">
        <a href="registerdonor.php" class="btn">Register as Donor</a>
        <a href="blood-request.php" class="btn">Request Blood</a>
        <a href="search.php" class="btn">Search Blood</a>
        <a href="blood-inventory.php" class="btn">Blood Inventory</a>
        <a href="events.php" class="btn">Donation Events</a>
        <a href="contact.php" class="btn">Contact Us</a>
        <a href="about.php" class="btn">About Us</a>
        <a href="admin-login.php" class="btn">Admin Login</a>
    </div>

    <div class="main-content">
        <h1>Welcome to <span style="color: #ffcc00;">Blood Bank Management System</span></h1>
        <p>Donate blood, <span style="color: #ffd700;">save lives</span>. <span style="color: #00ffea;">Join our mission</span> to connect donors and those in need efficiently. <span style="color: #ffcccb;">Access donor registration, search for available blood, and manage blood inventory.</span></p>

        <div class="features">
            <div class="feature-box">
                <h3>Become a Donor</h3>
                <p>Join our donor network and help save lives by donating regularly.</p>
            </div>
            <div class="feature-box">
                <h3>Request Blood</h3>
                <p>Search for the required blood group and submit a request with ease.</p>
            </div>
            <div class="feature-box">
                <h3>Upcoming Events</h3>
                <p>Check blood donation camps near you and get involved in your community.</p>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2025 Blood Bank. All rights reserved.
    </footer>
</body>
</html>
