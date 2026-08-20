<?php
// 1. Include the database connection file
include "database.php";

// 2. Collect user input from the form
$first_name = $_POST["first_name"];
$last_name  = $_POST["last_name"];
$email      = $_POST["email"];
$password   = $_POST["password"];
$role       = $_POST["role"];
// 3. Write the SQL query to insert data
$sql = "INSERT INTO user (first_name, last_name, email, password, role) 
        VALUES ('$first_name', '$last_name', '$email', '$password', '$role')";

// 4. Execute the query
if ($conn->query($sql)) {
   header ("Location: ../index.html");
   exit();
} else {
    echo "Error: " . $conn->error;
}
?>