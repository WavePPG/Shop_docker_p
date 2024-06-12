<?php
session_start();

include('../server.php'); // แก้ไขเป็นเส้นทางที่ถูกต้องสำหรับไฟล์ server.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, hashed_password, salt FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $salt);
        $stmt->fetch();

        // Verify password
        if (password_verify($password . $salt, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            header("Location: ../product.php"); // Redirect to dashboard or home page
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h2>Login</h2>
        <?php
        if (!empty($error)) {
            echo '<p class="error">' . $error . '</p>';
        }
        ?>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Login</button>
        </form>
        <div class="links">
            <p>If you don't have an account, please <a href="register.php">register here</a>.</p>
            <p>Forgot your password? <a href="forgot_password.php">Click here to reset it</a>.</p>
        </div>
    </div>
</body>

</html>