<?php
include "../database/database.php";

$id = $_GET["id"];

$sql = "SELECT * FROM rooms WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Room not found";
    exit();
}

$room = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $room_no = $_POST["room_no"];
    $type = $_POST["type"];
    $price = $_POST["price"];
    $status = $_POST["status"];

    $sql = "UPDATE rooms SET
            room_no = '$room_no',
            type = '$type',
            price = '$price',
            status = '$status'
            WHERE id = '$id'";

    if ($conn->query($sql)) {
        header("Location: rooms.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Room</title>

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

input,
select {
    width: 100%;
    height: 40px;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: #fff;
}

input:focus,
select:focus {
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

<h2>Edit Room</h2>

<form method="POST">

    <div class="form-group">

        <label>Room Number</label>

        <input type="text"
               name="room_no"
               value="<?php echo htmlspecialchars($room["room_no"]); ?>"
               required>

    </div>

    <div class="form-group">

        <label>Room Type</label>

        <select name="type" required>

            <option value="Single Room"
            <?php if ($room["type"] == "Single Room") echo "selected"; ?>>
            Single Room
            </option>

            <option value="Double Room"
            <?php if ($room["type"] == "Double Room") echo "selected"; ?>>
            Double Room
            </option>

            <option value="Delux Room"
            <?php if ($room["type"] == "Delux Room") echo "selected"; ?>>
            Delux Room
            </option>

        </select>

    </div>

    <div class="form-group">

        <label>Price / Night</label>

        <input type="number"
               name="price"
               step="0.01"
               value="<?php echo htmlspecialchars($room["price"]); ?>"
               required>

    </div>

    <div class="form-group">

        <label>Status</label>

        <select name="status" required>

            <option value="Available"
            <?php if ($room["status"] == "Available") echo "selected"; ?>>
            Available
            </option>

            <option value="Occupied"
            <?php if ($room["status"] == "Occupied") echo "selected"; ?>>
            Occupied
            </option>

            <option value="Maintenance"
            <?php if ($room["status"] == "Maintenance") echo "selected"; ?>>
            Maintenance
            </option>

        </select>

    </div>

    <div class="buttons">

        <button class="save" type="submit">
            Save Changes
        </button>

        <button class="cancel"
                type="button"
                onclick="window.location.href='rooms.php'">
            Cancel
        </button>

    </div>

</form>

</div>

<script src="navbar.js"></script>

</body>
</html>