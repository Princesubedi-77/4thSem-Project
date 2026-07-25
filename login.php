<?php
session_start();
include "database.php";

$first_name = $_POST["first_name"];
$password = $_POST["password"];

$sql = "SELECT * FROM USER WHERE
first_name = '$first_name' AND
password = '$password'";

$result = $conn->query($sql);

if ($result->num_rows>0) {

    $_SESSION["user"] = $first_name;
header("location: Dashboard.html"); 
exit();
}
else {
    echo "Username or Password is incorrect";
} 
?>