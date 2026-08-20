<?php
include "database.php";

$id = $_GET["id"];

$sql = "DELETE FROM staff WHERE id = '$id'";

if ($conn->query($sql)) {
    header("Location: ../page/staff.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>