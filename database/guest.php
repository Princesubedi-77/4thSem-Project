<?php
include "database.php";

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];

$sql = "INSERT INTO guest (name,email,phone)
        VALUES ('$name','$email','$phone')";

        if($conn->query($sql)){
            header("location: /hms/page/guest.html");
            exit();
        }
        else {
            echo " Try again";
        }
?>