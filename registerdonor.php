<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register as Donor</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2BjFcg6Sp0FkUslmmrCuWQQPFlTn0e23efg&s.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
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

        .form-container {
            position: relative;
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffe600;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #00ffd0;
            color: #000;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #00bfa5;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #ffffff20;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Register as a Donor</h2>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="number" name="age" placeholder="Age" required>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
        </select>
        <select name="blood_group" required>
            <option value="">Select Blood Group</option>
            <option>A+</option>
            <option>A-</option>
            <option>B+</option>
            <option>B-</option>
            <option>AB+</option>
            <option>AB-</option>
            <option>O+</option>
            <option>O-</option>
        </select>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="address" placeholder="Home Address" required>
        <select name="available" required>
            <option value="">Available to Donate?</option>
            <option>Yes</option>
            <option>No</option>
        </select>
        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        include("connect.php");

        $name = $_POST["name"];
        $age = $_POST["age"];
        $gender = $_POST["gender"];
        $blood_group = $_POST["blood_group"];
        $contact = $_POST["contact"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $available = $_POST["available"];

        $stmt = $conn->prepare("INSERT INTO donors (name, age, gender, blood_group, contact, email, address, available) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissssss", $name, $age, $gender, $blood_group, $contact, $email, $address, $available);

        if ($stmt->execute()) {
            echo "<div class='result'><h3>Donor Registered Successfully!</h3></div>";
        } else {
            echo "<div class='result'><h3>Error: " . $stmt->error . "</h3></div>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</div>

</body>
</html>
