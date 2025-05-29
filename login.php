<?php
session_start();
include 'connect.php';  // Include the database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check if username exists in the database
    $sql = "SELECT * FROM admin_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If username exists, check the password
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            // If valid, start the session and redirect to the admin dashboard
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: admin-dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login - Blood Bank</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: url('https://c8.alamy.com/comp/2H36631/admin-login-sign-made-of-wood-on-a-table-2H36631.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.7);
      padding: 60px 30px;
      border-radius: 15px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.8);
      color: #fff;
    }

    .overlay h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #ffcc00;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      color: #ddd;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border-radius: 6px;
      border: none;
      font-size: 16px;
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      background: linear-gradient(45deg, #ff416c, #ff4b2b);
      color: white;
      font-weight: bold;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn-login:hover {
      background: linear-gradient(45deg, #ff4b2b, #ff416c);
    }

    .footer-text {
      text-align: center;
      margin-top: 20px;
      font-size: 13px;
      color: #aaa;
    }

    @media (max-width: 500px) {
      .overlay {
        padding: 40px 20px;
      }

      .overlay h2 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="overlay">
    <h2>Admin Login</h2>
    <form action="login.php" method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter admin username" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required />
      </div>

      <button type="submit" class="btn-login">Login</button>

      <?php
      if (isset($error)) {
          echo "<div style='color: red; text-align: center; margin-top: 10px;'>$error</div>";
      }
      ?>
    </form>
    <div class="footer-text">&copy; 2025 Blood Bank System</div>
  </div>
</body>
</html>
