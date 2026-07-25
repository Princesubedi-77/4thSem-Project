<?php
include "database.php";

$first_name = $_POST["first_name"];
$last_name = $_POST ["last_name"];
$email = $_POST["email"];
$password = $_POST["password"];

// $sql = "INSERT INTO 
// user(first_name,last_name,email,password)"

$conn->query($sqli);

echo "account created";
?>