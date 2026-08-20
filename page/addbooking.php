<?php
include "../database/database.php";

$guests = $conn->query("SELECT id, Name FROM guest ORDER BY Name");
$rooms = $conn->query("SELECT id, room_no, type, price, status FROM rooms WHERE status = 'Available' ORDER BY room_no");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Booking</title>

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
            margin-top: 0;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 11px;
            background: #000;
            color: #fff;
            border: 0;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn:hover {
            background: #333;
        }
    </style>
</head>

<body>

<div id="navbar"></div>

<div class="container">

    <h2>Add Booking</h2>

    <form action="../database/savebooking.php" method="POST">

        <div class="form-group">
            <label>Guest</label>

            <select name="guest_id" required>
                <option value="">Select Guest</option>

                <?php while ($guest = $guests->fetch_assoc()) { ?>
                    <option value="<?php echo $guest['id']; ?>">
                        <?php echo htmlspecialchars($guest['Name']); ?>
                    </option>
                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label>Room</label>

            <select name="room_id" required>
                <option value="">Select Room</option>

                <?php while ($room = $rooms->fetch_assoc()) { ?>
                    <option value="<?php echo $room['id']; ?>">
                        <?php echo htmlspecialchars($room['room_no']); ?>
                        -
                        <?php echo htmlspecialchars($room['type']); ?>
                        -
                        $<?php echo htmlspecialchars($room['price']); ?>
                    </option>
                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label>Check-In</label>
            <input type="date" name="check_in" required>
        </div>

        <div class="form-group">
            <label>Check-Out</label>
            <input type="date" name="check_out" required>
        </div>

        <div class="form-group">
            <label>Status</label>

            <select name="status">
                <option value="Pending">Pending</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Checked In">Checked In</option>
                <option value="Checked Out">Checked Out</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>

        <button class="btn" type="submit">Add Booking</button>

    </form>

</div>

<script src="navbar.js"></script>

</body>
</html>