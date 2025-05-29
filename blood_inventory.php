<?php
include 'connect.php'; // Include DB connection

// Handle Add New Blood Unit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_blood'])) {
        $group = $_POST['blood_group'];
        $units = $_POST['units'];
        $donated = $_POST['donation_date'];
        $expiry = $_POST['expiry_date'];

        $stmt = $conn->prepare("INSERT INTO blood_inventory (blood_group, units_available, donation_date, expiry_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $group, $units, $donated, $expiry);
        $stmt->execute();
    }

    if (isset($_POST['update_stock'])) {
        $group = $_POST['update_blood_group'];
        $units = $_POST['new_units'];

        $stmt = $conn->prepare("UPDATE blood_inventory SET units_available = ? WHERE blood_group = ?");
        $stmt->bind_param("is", $units, $group);
        $stmt->execute();
    }
}

// Fetch Inventory
$result = $conn->query("SELECT * FROM blood_inventory");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Inventory Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('https://previews.123rf.com/images/angellodeco/angellodeco1907/angellodeco190700009/127959159-hands-of-a-lab-technician-with-a-tube-of-blood-sample-and-in-the-background-a-rack-with-other.jpg');
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

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.1);
            margin: 0 auto 30px;
            max-width: 1000px;
        }

        .inventory-table th,
        .inventory-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ffffff44;
            color: #fff;
        }

        .inventory-table th {
            background-color: #ff4b2b;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 30px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
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

        footer {
            text-align: center;
            margin-top: 40px;
            color: #ccc;
        }

        .section-divider {
            height: 2px;
            background-color: #ffffff44;
            margin: 40px auto;
            width: 60%;
        }
    </style>
</head>
<body>
<div class="overlay">
    <h1>Blood Inventory Management</h1>

    <!-- Inventory Table -->
    <table class="inventory-table">
        <tr>
            <th>Blood Group</th>
            <th>Units Available</th>
            <th>Last Donated</th>
            <th>Expiry Date</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['blood_group']) ?></td>
            <td><?= $row['units_available'] ?></td>
            <td><?= $row['donation_date'] ?></td>
            <td><?= $row['expiry_date'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <!-- Add New Blood Unit -->
    <div class="form-container">
        <h2>Add New Blood Unit</h2>
        <form method="POST">
            <select name="blood_group" required>
                <option value="">Select Blood Group</option>
                <option>A+</option><option>A-</option><option>B+</option>
                <option>B-</option><option>O+</option><option>O-</option>
                <option>AB+</option><option>AB-</option>
            </select>
            <input type="number" name="units" placeholder="Number of Units" required>
            <input type="date" name="donation_date" required>
            <input type="date" name="expiry_date" required>
            <button type="submit" name="add_blood">Add to Inventory</button>
        </form>
    </div>

    <div class="section-divider"></div>

    <!-- Update Stock -->
    <div class="form-container">
        <h2>Update Existing Stock</h2>
        <form method="POST">
            <select name="update_blood_group" required>
                <option value="">Select Blood Group to Update</option>
                <option>A+</option><option>A-</option><option>B+</option>
                <option>B-</option><option>O+</option><option>O-</option>
                <option>AB+</option><option>AB-</option>
            </select>
            <input type="number" name="new_units" placeholder="New Unit Count" required>
            <button type="submit" name="update_stock">Update Stock</button>
        </form>
    </div>

    <footer>&copy; 2025 Blood Bank Inventory System. All rights reserved.</footer>
</div>
</body>
</html>
