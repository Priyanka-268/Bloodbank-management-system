<?php
// Database connection setup
$host = "localhost";
$user = "root";
$password = "";
$dbname = "bloodbank"; // Change this if your database name is different

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize result variable
$results = [];

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['blood-group']) && isset($_GET['location'])) {
    $bloodGroup = $_GET['blood-group'];
    $location = $_GET['location'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT * FROM donors WHERE blood_group = ? AND location LIKE ?");
    $likeLocation = "%" . $location . "%";
    $stmt->bind_param("ss", $bloodGroup, $likeLocation);
    $stmt->execute();
    $results = $stmt->get_result();
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
        /* (Same CSS as your original) */
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
            align-items: center;
            flex-direction: column;
        }

        .search-box {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
            text-align: center;
            margin-bottom: 20px;
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
            background-color: white;
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            padding: 20px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }

        .result-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .result-item:last-child {
            border-bottom: none;
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
                <option <?php if(isset($bloodGroup) && $bloodGroup == "A+") echo "selected"; ?>>A+</option>
                <option <?php if(isset($bloodGroup) && $bloodGroup == "A-") echo "selected"; ?>>A-</option>
                <option <?php if(isset($bloodGroup) && $bloodGroup == "B+") echo "selected"; ?>>B+</option>
                <option <?php if(isset($bloodGroup) && $bloodGroup == "B-") echo "selected"; ?>>B-</option>
                <option <?php if(isset($bloodGroup) && $bloodGroup == "AB+") echo "selected"; ?>>AB+</option>
                <option <?php if(isset($bloodGroup) && $bloodGroup == "AB-") echo "selected"; ?>>AB-</option>
                <option <?php if(isset($bloodGroup) && $bloodGroup == "O+") echo "selected"; ?>>O+</option>
                <option <?php if(isset($bloodGroup) && $bloodGroup == "O-") echo "selected"; ?>>O-</option>
            </select>

            <label for="location">Enter Location:</label>
            <input type="text" id="location" name="location" placeholder="City or Hospital Name" required value="<?php echo isset($location) ? htmlspecialchars($location) : ''; ?>">

            <button type="submit">Search Now</button>
        </form>
    </div>

    <?php if (!empty($results) && $results->num_rows > 0): ?>
    <div class="results">
        <h3>Matching Donors:</h3>
        <?php while($row = $results->fetch_assoc()): ?>
            <div class="result-item">
                <strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?><br>
                <strong>Blood Group:</strong> <?php echo htmlspecialchars($row['blood_group']); ?><br>
                <strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?><br>
                <strong>Contact:</strong> <?php echo htmlspecialchars($row['contact']); ?>
            </div>
        <?php endwhile; ?>
    </div>
    <?php elseif ($_SERVER["REQUEST_METHOD"] === "GET" && isset($bloodGroup)): ?>
    <div class="results">
        <p><strong>No matching donors found.</strong></p>
    </div>
    <?php endif; ?>

</body>
</html>
