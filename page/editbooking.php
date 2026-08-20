<?php
include "../database/database.php";

if (!isset($_GET["id"])) {
    die("Booking ID not found.");
}

$id = $_GET["id"];

$sql = "SELECT * FROM booking WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Booking not found.");
}

$booking = $result->fetch_assoc();

if (isset($_POST["update"])) {

    $guest_id = $_POST["guest_id"];
    $room_id = $_POST["room_id"];
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];
    $status = $_POST["status"];

    $sql = "UPDATE booking SET
            guest_id = '$guest_id',
            room_id = '$room_id',
            check_in = '$check_in',
            check_out = '$check_out',
            status = '$status'
            WHERE id = '$id'";

    if ($conn->query($sql)) {
        header("Location: booking.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$guests = $conn->query("SELECT id, Name FROM guest");
$rooms = $conn->query("SELECT id, room_no FROM rooms");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 100px auto 40px;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h2 {
            margin: 0 0 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 7px;
            color: #333;
        }

        input,
        select {
            width: 100%;
            height: 40px;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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

    <h2>Edit Booking</h2>

    <form method="POST">

        <div class="form-group">
            <label>Guest</label>

            <select name="guest_id" required>

                <?php while ($guest = $guests->fetch_assoc()) { ?>

                    <option value="<?php echo $guest["id"]; ?>"
                        <?php if ($guest["id"] == $booking["guest_id"]) echo "selected"; ?>>

                        <?php echo $guest["Name"]; ?>

                    </option>

                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label>Room</label>

            <select name="room_id" required>

                <?php while ($room = $rooms->fetch_assoc()) { ?>

                    <option value="<?php echo $room["id"]; ?>"
                        <?php if ($room["id"] == $booking["room_id"]) echo "selected"; ?>>

                        <?php echo $room["room_no"]; ?>

                    </option>

                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label>Check-In</label>

            <input type="date"
                   name="check_in"
                   value="<?php echo $booking["check_in"]; ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Check-Out</label>

            <input type="date"
                   name="check_out"
                   value="<?php echo $booking["check_out"]; ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Status</label>

            <select name="status" required>

                <option value="Pending"
                    <?php if ($booking["status"] == "Pending") echo "selected"; ?>>
                    Pending
                </option>

                <option value="Confirmed"
                    <?php if ($booking["status"] == "Confirmed") echo "selected"; ?>>
                    Confirmed
                </option>

                <option value="Checked In"
                    <?php if ($booking["status"] == "Checked In") echo "selected"; ?>>
                    Checked In
                </option>

                <option value="Checked Out"
                    <?php if ($booking["status"] == "Checked Out") echo "selected"; ?>>
                    Checked Out
                </option>

                <option value="Cancelled"
                    <?php if ($booking["status"] == "Cancelled") echo "selected"; ?>>
                    Cancelled
                </option>

            </select>
        </div>

        <div class="buttons">

            <button type="submit" name="update" class="save">
                Update Booking
            </button>

            <button type="button"
                    class="cancel"
                    onclick="window.location.href='booking.php'">
                Cancel
            </button>

        </div>

    </form>

</div>

<script src="navbar.js"></script>

</body>
</html>