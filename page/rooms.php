<?php
include "../database/database.php";

$status = $_GET["status"] ?? "all";

if ($status == "all") {
    $sql = "SELECT * FROM rooms ORDER BY id DESC";
} else {
    $status = $conn->real_escape_string($status);
    $sql = "SELECT * FROM rooms WHERE status = '$status' ORDER BY id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>HMS - Rooms Management</title>

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
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
    }

    .filter-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .filter-group label {
      font-size: 14px;
      font-weight: bold;
      color: #333;
    }

    .status-select {
      padding: 8px 12px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background: #fff;
      cursor: pointer;
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
      font-size: 15px;
    }

    .custom-table th {
      background: #000;
      color: #fff;
      padding: 14px 18px;
      text-align: left;
    }

    .custom-table td {
      padding: 14px 18px;
      border-bottom: 1px solid #e0e0e0;
      color: #333;
    }

    .custom-table tr:hover {
      background: #f5f5f5;
    }

    .status-badge {
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 13px;
      display: inline-block;
    }

    .status-available {
      background: #dcfce7;
      color: #15803d;
    }

    .status-occupied {
      background: #fee2e2;
      color: #b91c1c;
    }

    .status-maintenance {
      background: #fef3c7;
      color: #b45309;
    }

    .action-btn {
      background: none;
      border: 0;
      cursor: pointer;
      font-size: 15px;
      padding: 6px 8px;
      border-radius: 4px;
    }

    .btn-edit {
      color: #2563eb;
      margin-right: 6px;
    }

    .btn-delete {
      color: #dc2626;
    }

    .btn-edit:hover {
      background: #eff6ff;
    }

    .btn-delete:hover {
      background: #fef2f2;
    }
  </style>
</head>

<body>

<div id="navbar"></div>

<div class="container">

  <div class="action-bar">

    <div class="filter-group">

      <label>Filter Status:</label>

      <select id="statusFilter" class="status-select">

        <option value="all">All Rooms</option>
        <option value="Available">Available</option>
        <option value="Occupied">Occupied</option>
        <option value="Maintenance">Maintenance</option>

      </select>

    </div>

    <button class="btn-add" onclick="window.location.href='addroom.php'">
      + Add Room
    </button>

  </div>

  <table class="custom-table">

    <thead>
      <tr>
        <th>Room No</th>
        <th>Type</th>
        <th>Price / Night</th>
        <th>Status</th>
        <th style="text-align:center;">Actions</th>
      </tr>
    </thead>

    <tbody>

    <?php

    if ($result->num_rows > 0) {

      while ($room = $result->fetch_assoc()) {

        $statusClass = strtolower($room["status"]);

    ?>

      <tr>

        <td>
          <strong><?php echo htmlspecialchars($room["room_no"]); ?></strong>
        </td>

        <td>
          <?php echo htmlspecialchars($room["type"]); ?>
        </td>

        <td>
          $<?php echo htmlspecialchars($room["price"]); ?>
        </td>

        <td>
          <span class="status-badge status-<?php echo $statusClass; ?>">
            <?php echo htmlspecialchars($room["status"]); ?>
          </span>
        </td>

        <td style="text-align:center;">

          <a href="editroom.php?id=<?php echo $room["id"]; ?>">
            <button class="action-btn btn-edit">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>
          </a>

          <a href="../database/deleteroom.php?id=<?php echo $room["id"]; ?>"
             onclick="return confirm('Are you sure you want to delete this room?');">

            <button class="action-btn btn-delete">
              <i class="fa-solid fa-trash"></i>
            </button>

          </a>

        </td>

      </tr>

    <?php

      }

    } else {

    ?>

      <tr>
        <td colspan="5" style="text-align:center;">
          No rooms found
        </td>
      </tr>

    <?php } ?>

    </tbody>

  </table>

</div>

<script src="navbar.js"></script>

<script>

document.getElementById("statusFilter").value =
"<?php echo htmlspecialchars($status); ?>";

document.getElementById("statusFilter").addEventListener("change", function() {

    window.location.href =
    "rooms.php?status=" + encodeURIComponent(this.value);

});

</script>

</body>
</html>