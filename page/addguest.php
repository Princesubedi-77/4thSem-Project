<?php
include "../database/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    $sql = "INSERT INTO guest (Name, Email, phone)
            VALUES ('$name', '$email', '$phone')";

    if ($conn->query($sql)) {
        header("Location: guest.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Guest</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #fff;
    margin: 0;
}

.container {
    max-width: 600px;
    margin: 100px auto;
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

h2 {
    margin-top: 0;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 18px;
}

label {
    display: block;
    font-size: 13px;
    margin-bottom: 7px;
    color: #555;
}

input {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input:focus {
    outline: none;
    border-color: #000;
}

.buttons {
    display: flex;
    gap: 10px;
    margin-top: 25px;
}

button {
    padding: 10px 20px;
    border: 0;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}

.save {
    background: #000;
    color: #fff;
}

.cancel {
    background: #eee;
    color: #000;
}
</style>

</head>

<body>

<div id="navbar"></div>

<div class="container">

<h2>Add Guest</h2>

<form method="POST">

    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>

    <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" required>
    </div>

    <div class="buttons">
        <button class="save" type="submit">Add Guest</button>
        <button class="cancel" type="button" onclick="window.location.href='guest.php'">
            Cancel
        </button>
    </div>

</form>

</div>

<script src="navbar.js"></script>

</body>
</html>