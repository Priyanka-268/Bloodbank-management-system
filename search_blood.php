<?php
include 'connect.php'; // include your DB connection ($conn)

$results = [];
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['blood-group']) && isset($_GET['location'])) {
    $blood_group = trim($_GET['blood-group']);
    $location = trim($_GET['location']);

    if ($blood_group && $location) {
        $stmt = $conn->prepare("SELECT donor_name, blood_group, location, contact FROM blood_inventory WHERE blood_group = ? AND location LIKE ?");
        $search_location = "%" . $location . "%";
        $stmt->bind_param("ss", $blood_group, $search_location);
        $stmt->execute();
        $result = $stmt->get_result();
        $results = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $error = "Please provide both blood group and location.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Blood</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background-image: url('https://t4.ftcdn.net/jpg/03/22/10/15/360_F_322101536_UaClSY3BDhLDWjgccwHmVPVT4ShY5riP.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: start;
            padding-top: 50px;
        }

        .search-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 600px;
            text-align: center;
        }

        h2 {
            color: #d50000;
            margin-bottom: 25px;
            font-size: 32px;
        }

        label {
            display: block;
            text-align: left;
            color: #333;
            margin-bottom: 10px;
            font-weight: 500;
        }

        select, input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #ff1744;
            color: white;
            font-weight: 600;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #d50000;
        }

        .results {
            margin-top: 20px;
            text-align: left;
        }

        .result-item {
            background: #ffeaea;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .result-item strong {
            color: #d50000;
        }

        .error {
            color: red;
            margin-top: 15px;
        }

        @media screen and (max-width: 600px) {
            .search-box {
                padding: 25px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="search-box">
        <h2>Search for Available Blood</h2>
        <form action="" method="GET">
            <label for="blood-group">Select Blood Group:</label>
            <select name="blood-group" id="blood-group" required>
                <option value="">-- Choose Blood Group --</option>
                <option <?= ($_GET['blood-group'] ?? '') == 'A+' ? 'selected' : '' ?>>A+</option>
                <option <?= ($_GET['blood-group'] ?? '') == 'A-' ? 'selected' : '' ?>>A-</option>
                <option <?= ($_GET['blood-group'] ?? '') == 'B+' ? 'selected' : '' ?>>B+</option>
                <option <?= ($_GET['blood-group'] ?? '') == 'B-' ? 'selected' : '' ?>>B-</option>
                <option <?= ($_GET['blood-group'] ?? '') == 'AB+' ? 'selected' : '' ?>>AB+</option>
                <option <?= ($_GET['blood-group'] ?? '') == 'AB-' ? 'selected' : '' ?>>AB-</option>
                <option <?= ($_GET['blood-group'] ?? '') == 'O+' ? 'selected' : '' ?>>O+</option>
                <option <?= ($_GET['blood-group'] ?? '') == 'O-' ? 'selected' : '' ?>>O-</option>
            </select>

            <label for="location">Enter Location:</label>
            <input type="text" id="location" name="location" placeholder="City or Hospital Name" required value="<?= htmlspecialchars($_GET['location'] ?? '') ?>">

            <button type="submit">Search Now</button>
        </form>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <?php if (!empty($results)): ?>
            <div class="results">
                <h3>Available Blood Units:</h3>
                <?php foreach ($results as $row): ?>
                    <div class="result-item">
                        <p><strong>Donor:</strong> <?= htmlspecialchars($row['donor_name']) ?></p>
                        <p><strong>Blood Group:</strong> <?= htmlspecialchars($row['blood_group']) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                        <p><strong>Contact:</strong> <?= htmlspecialchars($row['contact']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['blood-group'])): ?>
            <div class="results"><p>No matching blood units found.</p></div>
        <?php endif; ?>
    </div>
</body>
</html>
