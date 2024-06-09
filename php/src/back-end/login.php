<?php
// Start the session
session_start();

// Database connection
include('../server.php'); 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($hashed_password);

    // Fetch value
    if ($stmt->fetch()) {
        // Verify password
        if (hash('sha256', $password) === $hashed_password) {
            // Set the session variable to indicate that the admin is logged in
            $_SESSION['admin_logged_in'] = true;

            // Redirect to the admin page
            header("Location: admin_page.php");
            exit();
        } else {
            // Display an error message
            $error = "Invalid username or password";
        }
    } else {
        // Display an error message
        $error = "Invalid username or password";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <?php
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
</body>
</html>
