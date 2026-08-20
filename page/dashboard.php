<?php
include "../database/database.php";

$totalRooms = 0;
$availableRooms = 0;
$todayBookings = 0;
$totalGuests = 0;

$result = $conn->query("SELECT COUNT(*) AS total FROM rooms");
if ($result) {
    $totalRooms = $result->fetch_assoc()["total"];
}

$result = $conn->query("SELECT COUNT(*) AS total FROM rooms WHERE status = 'Available'");
if ($result) {
    $availableRooms = $result->fetch_assoc()["total"];
}

$result = $conn->query("SELECT COUNT(*) AS total FROM booking WHERE check_in = CURDATE()");
if ($result) {
    $todayBookings = $result->fetch_assoc()["total"];
}

$result = $conn->query("SELECT COUNT(*) AS total FROM guest");
if ($result) {
    $totalGuests = $result->fetch_assoc()["total"];
}

$recentBookings = $conn->query("
    SELECT 
        guest.Name,
        rooms.room_no,
        booking.check_in,
        booking.check_out,
        booking.status
    FROM booking
    JOIN guest ON booking.guest_id = guest.id
    JOIN rooms ON booking.room_id = rooms.id
    ORDER BY booking.id DESC
    LIMIT 5
");

$roomStatus = $conn->query("
    SELECT room_no, type, status
    FROM rooms
    ORDER BY id ASC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

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

    h2 {
      margin: 0 0 20px;
      font-size: 24px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
      margin-bottom: 30px;
    }

    .card {
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 20px;
      background: #fff;
    }

    .card h3 {
      margin: 0 0 10px;
      font-size: 14px;
      color: #555;
    }

    .card p {
      margin: 0;
      font-size: 26px;
      font-weight: bold;
    }

    .section {
      margin-bottom: 30px;
    }

    .section h3 {
      margin-bottom: 15px;
      font-size: 18px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    th {
      background: #000;
      color: #fff;
      padding: 12px 15px;
      text-align: left;
    }

    td {
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
    }

    tr:hover {
      background: #f5f5f5;
    }

    .status {
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 13px;
      border: 1px solid #ccc;
    }

    .available {
      background: #f1f5f9;
    }

    .occupied {
      background: #e5e5e5;
    }

    .maintenance {
      background: #ddd;
    }

    @media (max-width: 700px) {
      .cards {
        grid-template-columns: repeat(2, 1fr);
      }
    }
  </style>
</head>

<body>

  <div id="navbar"></div>

  <div class="container">

    <h2>Dashboard</h2>

    <div class="cards">

      <div class="card">
        <h3>Total Rooms</h3>
        <p><?php echo $totalRooms; ?></p>
      </div>

      <div class="card">
        <h3>Available Rooms</h3>
        <p><?php echo $availableRooms; ?></p>
      </div>

      <div class="card">
        <h3>Today's Bookings</h3>
        <p><?php echo $todayBookings; ?></p>
      </div>

      <div class="card">
        <h3>Total Guests</h3>
        <p><?php echo $totalGuests; ?></p>
      </div>

    </div>

    <div class="section">

      <h3>Recent Bookings</h3>

      <table>

        <thead>
          <tr>
            <th>Guest</th>
            <th>Room</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Status</th>
          </tr>
        </thead>

        <tbody>

        <?php if ($recentBookings && $recentBookings->num_rows > 0) { ?>

          <?php while ($row = $recentBookings->fetch_assoc()) { ?>

            <tr>

              <td>
                <?php echo htmlspecialchars($row["Name"]); ?>
              </td>

              <td>
                <?php echo htmlspecialchars($row["room_no"]); ?>
              </td>

              <td>
                <?php echo htmlspecialchars($row["check_in"]); ?>
              </td>

              <td>
                <?php echo htmlspecialchars($row["check_out"]); ?>
              </td>

              <td>
                <?php echo htmlspecialchars($row["status"]); ?>
              </td>

            </tr>

          <?php } ?>

        <?php } else { ?>

          <tr>
            <td colspan="5" style="text-align:center;">
              No bookings found
            </td>
          </tr>

        <?php } ?>

        </tbody>

      </table>

    </div>

    <div class="section">

      <h3>Room Status</h3>

      <table>

        <thead>
          <tr>
            <th>Room</th>
            <th>Type</th>
            <th>Status</th>
          </tr>
        </thead>

        <tbody>

        <?php if ($roomStatus && $roomStatus->num_rows > 0) { ?>

          <?php while ($row = $roomStatus->fetch_assoc()) { ?>

            <?php
            $status = strtolower($row["status"]);
            ?>

            <tr>

              <td>
                <?php echo htmlspecialchars($row["room_no"]); ?>
              </td>

              <td>
                <?php echo htmlspecialchars($row["type"]); ?>
              </td>

              <td>

                <span class="status <?php echo $status; ?>">
                  <?php echo htmlspecialchars($row["status"]); ?>
                </span>

              </td>

            </tr>

          <?php } ?>

        <?php } else { ?>

          <tr>
            <td colspan="3" style="text-align:center;">
              No rooms found
            </td>
          </tr>

        <?php } ?>

        </tbody>

      </table>

    </div>

  </div>

  <script src="navbar.js"></script>

</body>
</html>