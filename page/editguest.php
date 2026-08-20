<?php
include "../database/database.php";

$id = $_GET["id"];

$sql = "SELECT * FROM guest WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Guest not found";
    exit();
}

$guest = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    $sql = "UPDATE guest SET
            Name = '$name',
            Email = '$email',
            phone = '$phone'
            WHERE id = '$id'";

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

<title>Edit Guest</title>

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

<h2>Edit Guest</h2>

<form method="POST">

    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name"
               value="<?php echo htmlspecialchars($guest["Name"]); ?>"
               required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email"
               value="<?php echo htmlspecialchars($guest["Email"]); ?>"
               required>
    </div>

    <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone"
               value="<?php echo htmlspecialchars($guest["phone"]); ?>"
               required>
    </div>

    <div class="buttons">
        <button class="save" type="submit">Save Changes</button>

        <button class="cancel" type="button"
                onclick="window.location.href='guest.php'">
            Cancel
        </button>
    </div>

</form>

</div>

<script src="navbar.js"></script>

</body>
</html>