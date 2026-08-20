<?php
session_start();
include "database.php";

$first_name = $_POST["first_name"];
$password = $_POST["password"];

$sql = "SELECT * FROM USER WHERE
first_name = '$first_name' AND
password = '$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    $_SESSION["user_id"] = $user["USER_ID"];
    $_SESSION["user"] = $first_name;

    header("Location: /HMS/page/dashboard.html");
    exit();
}
else {
    echo "<script>
    alert('Incorrect Username or Password');
    history.back();
    </script>";
}
?>