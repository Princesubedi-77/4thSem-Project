<?php

include "database.php";

$id = $_GET["id"];

$sql = "DELETE FROM rooms WHERE id = '$id'";

if ($conn->query($sql)) {

    header("Location: ../page/rooms.php");
    exit();

} else {

    echo "Error: " . $conn->error;

}

?>