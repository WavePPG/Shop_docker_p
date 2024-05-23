<?php
// Define the path to the .cfg file
$config_file_path = 'config.cfg';

// Check if the file exists
if (!file_exists($config_file_path)) {
    die("Config file not found.");
}

// Parse the .cfg file assuming it's in INI format
$config = parse_ini_file($config_file_path, true);

// Check if 'database' section and 'password' key exist
if (isset($config['database']) && isset($config['database']['password'])) {
    $password = $config['database']['password'];
    // echo "Password extracted: " . $password; // Displaying the password like this is not secure!

    // Rest of your code to establish database connection using extracted password
    // ...
    $servername = $config['database']['host'];
    $username = $config['database']['user'];
    $dbname = $config['database']['dbname'];

    // Create Connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        // echo "Connected successfully!";
    }
} else {
    die("Unable to extract database password from configuration file.");
}
?>