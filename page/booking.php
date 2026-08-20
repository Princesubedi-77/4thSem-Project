<?php
include "../database/database.php";

$sql = "SELECT 
            booking.id,
            guest.Name AS guest_name,
            rooms.room_no,
            rooms.type,
            rooms.price,
            booking.check_in,
            booking.check_out,
            booking.status
        FROM booking
        JOIN guest ON booking.guest_id = guest.id
        JOIN rooms ON booking.room_id = rooms.id
        ORDER BY booking.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HMS - Booking Management</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            margin: 0;
        }

        .container {
            max-width: 950px;
            margin: 100px auto 40px;
            padding: 0 20px;
        }

        .action-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 16px;
        }

        .btn-add {
            background: #000;
            color: #fff;
            border: 0;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-add:hover {
            background: #333;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .custom-table th {
            background: #000;
            color: #fff;
            padding: 14px 12px;
            text-align: left;
        }

        .custom-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #ddd;
        }

        .custom-table tr:hover {
            background: #f5f5f5;
        }

        .status {
            padding: 5px 10px;
            border-radius: 12px;
            border: 1px solid #ccc;
            font-size: 12px;
        }

        .action-btn {
            background: none;
            border: 0;
            cursor: pointer;
            font-size: 15px;
            padding: 6px;
        }

        .edit {
            color: #2563eb;
        }

        .delete {
            color: #dc2626;
        }
    </style>
</head>

<body>

<div id="navbar"></div>

<div class="container">

    <div class="action-bar">
        <button class="btn-add" onclick="window.location.href='addbooking.php'">
            + Add Booking
        </button>
    </div>

    <table class="custom-table">

        <thead>
            <tr>
                <th>S.No</th>
                <th>Guest</th>
                <th>Room</th>
                <th>Type</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $i = 1;

        while ($row = $result->fetch_assoc()) {
        ?>

            <tr>

                <td><?php echo $i++; ?></td>

                <td>
                    <?php echo htmlspecialchars($row["guest_name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row["room_no"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row["type"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row["check_in"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row["check_out"]); ?>
                </td>

                <td>
                    <span class="status">
                        <?php echo htmlspecialchars($row["status"]); ?>
                    </span>
                </td>

                <td>

                    <button class="action-btn edit"
                        onclick="window.location.href='editbooking.php?id=<?php echo $row['id']; ?>'">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <button class="action-btn delete"
                        onclick="deleteBooking(<?php echo $row['id']; ?>)">
                        <i class="fa-solid fa-trash"></i>
                    </button>

                </td>

            </tr>

        <?php
        }
        ?>

        </tbody>

    </table>

</div>

<script src="navbar.js"></script>

<script>
function deleteBooking(id) {
    if (confirm("Are you sure you want to delete this booking?")) {
        window.location.href = "../database/deletebooking.php?id=" + id;
    }
}
</script>

</body>
</html>