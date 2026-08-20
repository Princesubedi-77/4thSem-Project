<?php
include "database.php";

$id = $_GET["id"];

$sql = "DELETE FROM guest WHERE id = '$id'";

if ($conn->query($sql)) {
    header("Location: ../page/guest.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>