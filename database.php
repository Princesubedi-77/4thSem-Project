<?php
// $host = "localhost";
// $username = "root";
// $password= "";
// $database = "user_db"

$conn = new mysqli("localhost", "root", "","user_db");

if ($conn-> connect_error){
    die("connection failed: ". $conn->connect_error);
}

echo "Connect vayo";
?> 

