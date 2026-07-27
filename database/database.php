<?php
// 1. Connect to the database
$conn = new mysqli("localhost", "root", "", "user_db");

// 2. Check if the connection worked
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Success message
echo "Connected successfully!";
?>