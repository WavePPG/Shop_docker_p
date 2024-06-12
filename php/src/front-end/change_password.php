<?php
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: /front-end/login.php");
    exit();
}

// Database connection
include('../server.php'); // แก้ไขเป็นเส้นทางที่ถูกต้องสำหรับไฟล์ server.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $stmt = $conn->prepare("SELECT hashed_password, salt FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $salt);
    $stmt->fetch();
    $stmt->close();

    // ตรวจสอบรหัสผ่านเก่า
    if (password_verify($old_password . $salt, $hashed_password)) {
        // ตรวจสอบว่ารหัสผ่านใหม่และยืนยันรหัสผ่านใหม่ตรงกัน
        if ($new_password === $confirm_password) {
            // สร้าง salt และ hash รหัสผ่านใหม่
            $new_salt = bin2hex(random_bytes(16));
            $new_hashed_password = password_hash($new_password . $new_salt, PASSWORD_BCRYPT);

            // อัปเดตรหัสผ่านในฐานข้อมูล
            $stmt = $conn->prepare("UPDATE users SET hashed_password = ?, salt = ? WHERE id = ?");
            $stmt->bind_param("ssi", $new_hashed_password, $new_salt, $user_id);
            if ($stmt->execute()) {
                $success = "Password changed successfully.";
            } else {
                $error = "Failed to update password.";
            }
            $stmt->close();
        } else {
            $error = "New passwords do not match.";
        }
    } else {
        $error = "Old password is incorrect.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>

<body>
    <h2>Change Password</h2>
    <?php
    if (!empty($error)) {
        echo '<p style="color:red;">' . $error . '</p>';
    }
    if (!empty($success)) {
        echo '<p style="color:green;">' . $success . '</p>';
    }
    ?>
    <form action="change_password.php" method="POST">
        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password" required>
        <br>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <br>
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>
        <button type="submit">Change Password</button>
    </form>
</body>

</html>