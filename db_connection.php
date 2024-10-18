<?php
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "nsdl@123";      // Your MySQL password
$dbname = "register";  // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
