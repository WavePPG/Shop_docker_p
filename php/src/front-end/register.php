<?php
session_start();

include('../server.php'); // แก้ไขเป็นเส้นทางที่ถูกต้องสำหรับไฟล์ server.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            $stmt->close();

            // Generate salt and hash the password
            $salt = bin2hex(random_bytes(16));
            $hashed_password = password_hash($password . $salt, PASSWORD_BCRYPT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, hashed_password, salt) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $salt);

            if ($stmt->execute()) {
                header("Location: login.php"); // Redirect to login page
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Username or email already exists";
        }
    } else {
        $error = "Passwords do not match";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f8f8;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #333333;
    }

    .error {
        color: red;
        margin-bottom: 10px;
    }

    label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        color: #333333;
    }

    input {
        width: calc(100% - 22px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #cccccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    button {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #0056b3;
    }

    .links {
        margin-top: 10px;
        color: #007BFF;
    }

    .links a {
        color: #007BFF;
        text-decoration: none;
    }

    .links a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <?php
        if (!empty($error)) {
            echo '<p class="error">' . $error . '</p>';
        }
        ?>
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <button type="submit">Register</button>
        </form>
        <div class="links">
            <p>If you have an account, please <a href="login.php">login here</a>.</p>
        </div>
    </div>
</body>

</html>