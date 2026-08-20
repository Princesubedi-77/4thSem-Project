<?php
include "../database/database.php";

if (!isset($_GET["id"])) {
    die("Checkout ID not found");
}

$id = $_GET["id"];

$sql = "SELECT 
            checkout.id,
            checkout.amount,
            checkout.payment_status,
            booking.check_in,
            booking.check_out,
            guest.Name,
            guest.Email,
            guest.phone,
            rooms.room_no,
            rooms.type,
            rooms.price
        FROM checkout
        JOIN booking ON checkout.booking_id = booking.id
        JOIN guest ON booking.guest_id = guest.id
        JOIN rooms ON booking.room_id = rooms.id
        WHERE checkout.id='$id'";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Receipt not found");
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout Receipt</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }

        .receipt {
            width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 35px;
            border: 1px solid #ddd;
        }

        h1 {
            text-align: center;
            margin: 0;
        }

        .hotel {
            text-align: center;
            margin-bottom: 30px;
        }

        .hotel p {
            margin: 5px;
            color: #666;
        }

        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .item {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .item label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .item strong {
            font-size: 15px;
        }

        .total {
            display: flex;
            justify-content: space-between;
            border-top: 2px solid #000;
            padding-top: 15px;
            font-size: 20px;
            font-weight: bold;
        }

        .status {
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
        }

        .buttons {
            text-align: center;
            margin-top: 30px;
        }

        button {
            padding: 10px 20px;
            border: 0;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin: 5px;
        }

        .print {
            background: #000;
            color: #fff;
        }

        .back {
            background: #ddd;
            color: #000;
        }

        @media print {
            body {
                background: #fff;
            }

            .receipt {
                margin: 0 auto;
                border: 0;
            }

            .buttons {
                display: none;
            }
        }
    </style>
</head>

<body>

<div class="receipt">

    <div class="hotel">
        <h1>HOTEL MANAGEMENT SYSTEM</h1>
        <p>Checkout Receipt</p>
    </div>

    <div class="info">

        <div class="item">
            <label>Checkout ID</label>
            <strong>#CO-<?php echo $data["id"]; ?></strong>
        </div>

        <div class="item">
            <label>Guest Name</label>
            <strong><?php echo htmlspecialchars($data["Name"]); ?></strong>
        </div>

        <div class="item">
            <label>Email</label>
            <strong><?php echo htmlspecialchars($data["Email"]); ?></strong>
        </div>

        <div class="item">
            <label>Phone</label>
            <strong><?php echo htmlspecialchars($data["phone"]); ?></strong>
        </div>

        <div class="item">
            <label>Room Number</label>
            <strong><?php echo htmlspecialchars($data["room_no"]); ?></strong>
        </div>

        <div class="item">
            <label>Room Type</label>
            <strong><?php echo htmlspecialchars($data["type"]); ?></strong>
        </div>

        <div class="item">
            <label>Check-In</label>
            <strong><?php echo $data["check_in"]; ?></strong>
        </div>

        <div class="item">
            <label>Check-Out</label>
            <strong><?php echo $data["check_out"]; ?></strong>
        </div>

    </div>

    <div class="status">
        Payment Status: <?php echo htmlspecialchars($data["payment_status"]); ?>
    </div>

    <div class="total">
        <span>Total Amount</span>
        <span>$<?php echo number_format($data["amount"], 2); ?></span>
    </div>

    <div class="buttons">
        <button class="print" onclick="window.print()">Print Receipt</button>

        <button class="back"
                onclick="window.location.href='checkout.php'">
            Back
        </button>
    </div>

</div>

</body>
</html>