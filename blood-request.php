<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = $_POST['patient_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $hospital_name = $_POST['hospital_name'];
    $city = $_POST['city'];
    $contact_number = $_POST['contact_number'];
    $reason = $_POST['reason'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "bloodbank_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO blood_requests (patient_name, age, gender, blood_group, hospital_name, city, contact_number, reason)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssss", $patient_name, $age, $gender, $blood_group, $hospital_name, $city, $contact_number, $reason);
    
    if ($stmt->execute()) {
        echo "<script>alert('Blood request submitted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to submit request. Please try again.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Request</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        /* CSS same as your original code */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url('https://www.shutterstock.com/image-vector/world-donor-day-abstract-wallpaper-600nw-2115749144.jpg');
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
            background-color: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }

        .form-box {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 1;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #ffcc00;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 15px;
        }

        textarea {
            resize: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #00ffd0;
            color: black;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        button:hover {
            background-color: #00bfa5;
        }

        @media (max-width: 600px) {
            .form-box {
                padding: 25px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Request Blood</h2>
        <form action="" method="POST">
            <input type="text" name="patient_name" placeholder="Patient Name" required>
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
            <input type="text" name="hospital_name" placeholder="Hospital Name" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="contact_number" placeholder="Contact Number" required>
            <textarea name="reason" rows="4" placeholder="Reason for blood request" required></textarea>
            <button type="submit">Submit Request</button>
        </form>
    </div>
</body>
</html>
