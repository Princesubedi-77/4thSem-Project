<?php
session_start();
include "database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.html");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "DELETE FROM USER WHERE USER_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    session_destroy();
    header("Location: ../index.html");
    exit();
}

echo "Unable to delete account.";
?>