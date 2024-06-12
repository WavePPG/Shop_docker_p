<?php
session_start();

include('../server.php'); // แก้ไขเป็นเส้นทางที่ถูกต้องสำหรับไฟล์ server.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Check token validity
        $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires > ?");
        $stmt->bind_param("ss", $token, date("U"));
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($email);
            $stmt->fetch();
            $stmt->close();

            // Update password
            $salt = bin2hex(random_bytes(16));
            $hashed_password = password_hash($new_password . $salt, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("UPDATE users SET hashed_password = ?, salt = ? WHERE email = ?");
            $stmt->bind_param("sss", $hashed_password, $salt, $email);
            $stmt->execute();
            $stmt->close();

            // Delete token
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            $success = "Your password has been reset successfully.";
        } else {
            $error = "Invalid or expired token.";
        }
    } else {
        $error = "Passwords do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <h2>Reset Password</h2>
    <?php
    if (!empty($error)) {
        echo '<p style="color:red;">' . $error . '</p>';
    }
    if (!empty($success)) {
        echo '<p style="color:green;">' . $success . '</p>';
    }
    ?>
    <form action="reset_password.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>
        <button type="submit">Reset Password</button>
    </form>
</body>

</html>