<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "discuss";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Set charset to utf8mb4 (best for international characters)
$conn->set_charset("utf8mb4");

// Handle connection error
if ($conn->connect_error) {
    // ✅ Don't expose raw DB error in live apps
    die("Database connection failed. Please try again later.");
}
?>
