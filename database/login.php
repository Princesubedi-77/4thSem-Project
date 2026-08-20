<?php
session_start();
include "database.php";

$first_name = $_POST["first_name"];
$password = $_POST["password"];

$sql = "SELECT count(*) FROM USER WHERE
first_name = '$first_name' AND
password = '$password'";

$result = $conn->query($sql);

if ($result > 0) {

    $_SESSION["user"] = $first_name;
header("Location: /HMS/page/dashboard.html"); 
exit();
}
else {
  echo "<script>
    alert ('Incorret Username or Password');
    history.back();
    </script>";
    
} 
?>