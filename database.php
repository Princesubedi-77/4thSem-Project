<?php
$host = "local host";
$username = "root";
$password= "";
$database = "user_db"

$conn = new mysql($host, $username, $password, $database);

if ($conn-> connect_error){
    die("connection failed: ". $conn->connect_error);
}

echo "Connect vayo";
?>

