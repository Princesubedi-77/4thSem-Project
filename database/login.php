<?php
session_start();
include "database.php";

$first_name = $_POST["first_name"];
$password = $_POST["password"];

$sql = "SELECT USER_ID, First_Name, PASSWORD FROM user WHERE First_Name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $first_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if ($password === $user["PASSWORD"]) {
        $_SESSION["user_id"] = $user["USER_ID"];
        $_SESSION["user"] = $user["First_Name"];
        header("Location: /HMS/page/dashboard.html");
        exit();
    } else {
        echo "<script>
            alert('Incorrect Username or Password');
            history.back();
        </script>";
    }
} else {
    echo "<script>
        alert('Incorrect Username or Password');
        history.back();
    </script>";
}

$stmt->close();
?>