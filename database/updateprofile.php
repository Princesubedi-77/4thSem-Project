<?php
session_start();
include "database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.html");
    exit();
}

$user_id = $_SESSION["user_id"];

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$role = $_POST["role"];

$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if (!empty($password)) {

    if ($password != $confirm_password) {
        echo "<script>
            alert('Passwords do not match');
            history.back();
        </script>";
        exit();
    }

    $sql = "UPDATE USER SET
            First_Name = '$first_name',
            Last_Name = '$last_name',
            Email = '$email',
            PASSWORD = '$password',
            role = '$role'
            WHERE USER_ID = '$user_id'";

} else {

    $sql = "UPDATE USER SET
            First_Name = '$first_name',
            Last_Name = '$last_name',
            Email = '$email',
            role = '$role'
            WHERE USER_ID = '$user_id'";
}

if ($conn->query($sql)) {

    header("Location: ../page/profile.php");
    exit();

} else {

    echo "Error: " . $conn->error;
}
?>