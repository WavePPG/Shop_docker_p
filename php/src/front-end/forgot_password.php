<?php
session_start();

include('../server.php'); // แก้ไขเป็นเส้นทางที่ถูกต้องสำหรับไฟล์ server.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username);
        $stmt->fetch();

        // Close statement
        $stmt->close();

        // Generate reset token
        $token = bin2hex(random_bytes(50));
        $expires = date("U") + 1800; // 30 minutes expiration

        // Insert reset token into database
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expires);
        $stmt->execute();
        $stmt->close();

        // Send reset email
        $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Hello $username,\n\nPlease click the following link to reset your password:\n$reset_link\n\nThis link will expire in 30 minutes.";
        $headers = "From: noreply@yourdomain.com";

        mail($email, $subject, $message, $headers);

        $success = "A password reset link has been sent to your email.";
    } else {
        $error = "No account found with that email address.";
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>

<body>
    <h2>Forgot Password</h2>
    <?php
    if (!empty($error)) {
        echo '<p style="color:red;">' . $error . '</p>';
    }
    if (!empty($success)) {
        echo '<p style="color:green;">' . $success . '</p>';
    }
    ?>
    <form action="forgot_password.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <button type="submit">Send Password Reset Link</button>
    </form>
</body>

</html>