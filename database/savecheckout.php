<?php

include "database.php";

$booking_id = $_POST["booking_id"];
$amount = $_POST["amount"];
$payment_status = $_POST["payment_status"];

$sql = "INSERT INTO checkout (booking_id, amount, payment_status)
        VALUES ('$booking_id', '$amount', '$payment_status')";

if ($conn->query($sql)) {
    header("Location: ../page/checkout.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

?>