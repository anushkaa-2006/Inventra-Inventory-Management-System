<?php
// Start session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";

// Create a connection to the MySQL server (without selecting a database)
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection to MySQL server failed: " . $conn->connect_error);
}
?>
