<?php
include "database.php";

$name =  $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$role = $_POST["role"];

$sql = "INSERT INTO staff (name, email, phone, role)
        VALUES ('$name','$email','$phone','$role')";

        if($conn-> query($sql)) {
            header ("location: /HMS/page/staff.html");
            exit();
        }
        else{
            echo "NOOOOOOOOOOOOO";
        }
?>