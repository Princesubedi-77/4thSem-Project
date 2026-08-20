<?php

include "database.php";

$guest_id = $_POST["guest_id"];
$room_id = $_POST["room_id"];
$check_in = $_POST["check_in"];
$check_out = $_POST["check_out"];
$status = $_POST["status"];

$sql = "INSERT INTO booking (guest_id, room_id, check_in, check_out, status)
        VALUES ('$guest_id', '$room_id', '$check_in', '$check_out', '$status')";

if ($conn->query($sql)) {
    header("Location: ../page/booking.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

?>