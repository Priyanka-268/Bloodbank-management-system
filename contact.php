<?php
include 'connect.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if ($name && $email && $subject && $message) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        if ($stmt->execute()) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Failed to send message. Please try again.";
        }
    } else {
        $error = "Please fill out all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Blood Bank System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('https://static.vecteezy.com/system/resources/previews/001/971/264/non_2x/beautiful-cherry-blossom-with-bokeh-lights-background-concept-free-vector.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: #fff;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.7);
            min-height: 100vh;
            padding: 50px 20px;
        }

        h1 {
            text-align: center;
            color: #ffcc00;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            color: #ccc;
            margin-bottom: 30px;
        }

        .contact-form {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-form input,
        .contact-form textarea,
        .contact-form button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 100px;
        }

        .contact-form button {
            background-color: #00ffd0;
            color: #000;
            font-weight: bold;
            transition: background 0.3s ease;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #00bfa5;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }

        .message.success {
            color: #00ff99;
        }

        .message.error {
            color: #ff4444;
        }

        footer {
            text-align: center;
            margin-top: 50px;
            color: #ccc;
        }

        @media (max-width: 600px) {
            .contact-form {
                padding: 20px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="overlay">
        <h1>Contact Us</h1>
        <p>Have a question or feedback? We’d love to hear from you.</p>

        <div class="contact-form">
            <?php if ($success): ?>
                <div class="message success"><?= $success ?></div>
            <?php elseif ($error): ?>
                <div class="message error"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" name="subject" placeholder="Subject" required>
                <textarea name="message" placeholder="Your Message or Feedback" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>

        <footer>
            &copy; 2025 Blood Bank Management System. Designed with ❤️.
        </footer>
    </div>
</body>
</html>
