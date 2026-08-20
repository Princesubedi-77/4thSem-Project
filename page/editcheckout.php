<?php
include "../database/database.php";

if (!isset($_GET["id"])) {
    die("Checkout ID not found");
}

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST["booking_id"];
    $amount = $_POST["amount"];
    $payment_status = $_POST["payment_status"];

    $sql = "UPDATE checkout SET 
            booking_id='$booking_id',
            amount='$amount',
            payment_status='$payment_status'
            WHERE id='$id'";

    if ($conn->query($sql)) {
        header("Location: checkout.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM checkout WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Checkout record not found");
}

$checkout = $result->fetch_assoc();

$bookings = $conn->query("
    SELECT booking.id, guest.Name, rooms.room_no
    FROM booking
    JOIN guest ON booking.guest_id = guest.id
    JOIN rooms ON booking.room_id = rooms.id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Checkout</title>

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

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 7px;
        }

        input,
        select {
            width: 100%;
            height: 40px;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
            margin-left: 8px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Edit Checkout</h2>

    <form method="POST">

        <label>Booking</label>

        <select name="booking_id" required>

            <?php while ($booking = $bookings->fetch_assoc()) { ?>

                <option value="<?php echo $booking["id"]; ?>"
                    <?php if ($booking["id"] == $checkout["booking_id"]) echo "selected"; ?>>

                    #<?php echo $booking["id"]; ?>
                    - <?php echo htmlspecialchars($booking["Name"]); ?>
                    - Room <?php echo htmlspecialchars($booking["room_no"]); ?>

                </option>

            <?php } ?>

        </select>

        <label>Amount</label>

        <input type="number" step="0.01" name="amount"
               value="<?php echo htmlspecialchars($checkout["amount"]); ?>"
               required>

        <label>Payment Status</label>

        <select name="payment_status" required>

            <option value="Paid"
                <?php if ($checkout["payment_status"] == "Paid") echo "selected"; ?>>
                Paid
            </option>

            <option value="Pending"
                <?php if ($checkout["payment_status"] == "Pending") echo "selected"; ?>>
                Pending
            </option>

            <option value="Unpaid"
                <?php if ($checkout["payment_status"] == "Unpaid") echo "selected"; ?>>
                Unpaid
            </option>

        </select>

        <button type="submit" class="save">Save Changes</button>

        <button type="button" class="cancel"
                onclick="window.location.href='checkout.php'">
            Cancel
        </button>

    </form>

</div>

</body>
</html>