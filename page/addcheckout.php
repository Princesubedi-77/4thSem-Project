<?php
include "../database/database.php";

$sql = "SELECT 
            booking.id,
            guest.Name AS guest_name,
            rooms.room_no,
            rooms.type,
            rooms.price,
            booking.check_in,
            booking.check_out
        FROM booking
        JOIN guest ON booking.guest_id = guest.id
        JOIN rooms ON booking.room_id = rooms.id
        WHERE booking.status != 'Cancelled'
        ORDER BY booking.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Process Checkout</title>

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

        select,
        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: #fff;
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

    <h2>Process Checkout</h2>

    <form action="../database/savecheckout.php" method="POST">

        <div class="form-group">
            <label>Booking</label>

            <select name="booking_id" required>

                <option value="">Select Booking</option>

                <?php while ($row = $result->fetch_assoc()) { ?>

                    <option value="<?php echo $row['id']; ?>">
                        <?php echo htmlspecialchars($row['guest_name']); ?>
                        -
                        Room <?php echo htmlspecialchars($row['room_no']); ?>
                        -
                        <?php echo htmlspecialchars($row['check_in']); ?>
                        to
                        <?php echo htmlspecialchars($row['check_out']); ?>
                    </option>

                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Payment Status</label>

            <select name="payment_status" required>
                <option value="Unpaid">Unpaid</option>
                <option value="Pending">Pending</option>
                <option value="Paid">Paid</option>
            </select>
        </div>

        <button class="btn" type="submit">Process Checkout</button>

    </form>

</div>

<script src="navbar.js"></script>

</body>
</html>