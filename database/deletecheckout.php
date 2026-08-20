<?php

include "database.php";

$id = $_GET["id"];

$sql = "DELETE FROM checkout WHERE id = '$id'";

if ($conn->query($sql)) {
    header("Location: ../page/checkout.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

?>