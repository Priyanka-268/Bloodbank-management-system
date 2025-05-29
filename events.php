<?php
include 'connect.php'; // make sure this contains $conn = new mysqli(...)

$success = "";
$error = "";

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name   = trim($_POST['name']);
    $email  = trim($_POST['email']);
    $phone  = trim($_POST['phone']);
    $event  = trim($_POST['event']);

    if ($name && $email && $phone && $event) {
        $stmt = $conn->prepare("INSERT INTO event_registrations (name, email, phone, event_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $event);

        if ($stmt->execute()) {
            $success = "You have successfully registered!";
        } else {
            $error = "Registration failed. Please try again.";
        }
    } else {
        $error = "Please fill in all the fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Donation Events</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('https://media.gettyimages.com/id/1199312560/video/4k-abstract-particle-wave-bokeh-background-red-glamour-love-beautiful-glitter-loop.jpg?s=640x640&k=20&c=XwNvY9W9xJog_B3wwh3oGQIZDUNC6EYFQbFObIjY9Qs=');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: #fff;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.7);
            min-height: 100vh;
            padding: 40px 20px;
        }

        h1, h2 {
            text-align: center;
            color: #ffcc00;
            margin-bottom: 20px;
        }

        .events-table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.1);
            margin: 0 auto 30px;
            max-width: 1000px;
        }

        .events-table th,
        .events-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ffffff44;
            color: #fff;
        }

        .events-table th {
            background-color: #ff4b2b;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 30px auto;
        }

        .form-container input,
        .form-container select,
        .form-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 6px;
            font-size: 16px;
        }

        .form-container button {
            background-color: #00ffd0;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .form-container button:hover {
            background-color: #00bfa5;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .message.success {
            color: #00ff99;
        }

        .message.error {
            color: #ff4444;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #ccc;
        }
    </style>
</head>
<body>
<div class="overlay">
    <h1>Upcoming Blood Donation Events</h1>

    <!-- Event List -->
    <table class="events-table">
        <tr>
            <th>Event Name</th>
            <th>Location</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
        <tr>
            <td>Red Cross Mega Camp</td>
            <td>City Hall, Karur</td>
            <td>2025-05-20</td>
            <td>10:00 AM - 4:00 PM</td>
        </tr>
        <tr>
            <td>LifeSaver Camp</td>
            <td>M.Kumarasamy College Auditorium</td>
            <td>2025-06-10</td>
            <td>9:00 AM - 3:00 PM</td>
        </tr>
        <tr>
            <td>Community Health Drive</td>
            <td>District Hospital Grounds</td>
            <td>2025-06-25</td>
            <td>11:00 AM - 5:00 PM</td>
        </tr>
    </table>

    <!-- Registration Form -->
    <div class="form-container">
        <h2>Register for an Event</h2>

        <?php if ($success): ?>
            <div class="message success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="Your Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <select name="event" required>
                <option value="">Select Event</option>
                <option>Red Cross Mega Camp - Karur</option>
                <option>LifeSaver Camp - MKCE</option>
                <option>Community Health Drive - Hospital</option>
            </select>
            <button type="submit">Register</button>
        </form>
    </div>

    <footer>
        &copy; 2025 Blood Bank System. All rights reserved.
    </footer>
</div>
</body>
</html>
