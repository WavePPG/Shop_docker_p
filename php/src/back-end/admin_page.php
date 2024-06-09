<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// The rest of your code goes here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav>
        <?php include('navbaronback-end.php')?>
    </nav>
</body>
</html>