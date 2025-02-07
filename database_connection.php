<?php
$servername = "localhost";  // Your database server (usually "localhost")
$username = "root";         // Your database username
$password = "";             // Your database password (leave it empty if there's no password)
$dbname = "gfi_exel"; // Your database name

// Create a new connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
