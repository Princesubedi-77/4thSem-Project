<?php
include "../database/database.php";

$sql = "SELECT 
            checkout.id,
            checkout.amount,
            checkout.payment_status,
            guest.Name,
            rooms.room_no
        FROM checkout
        JOIN booking ON checkout.booking_id = booking.id
        JOIN guest ON booking.guest_id = guest.id
        JOIN rooms ON booking.room_id = rooms.id
        ORDER BY checkout.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>HMS - Checkout Management</title>

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
      font-weight: 600;
    }

    .status-paid {
      background: #dcfce7;
      color: #15803d;
    }

    .status-pending {
      background: #fef3c7;
      color: #b45309;
    }

    .status-unpaid {
      background: #fee2e2;
      color: #b91c1c;
    }

    .action-btn {
      background: none;
      border: 0;
      cursor: pointer;
      font-size: 15px;
      padding: 6px 8px;
      border-radius: 4px;
      text-decoration: none;
    }

    .btn-process {
      color: #16a34a;
      margin-right: 6px;
    }

    .btn-edit {
      color: #2563eb;
      margin-right: 6px;
    }

    .btn-delete {
      color: #dc2626;
    }

    .btn-process:hover {
      background: #f0fdf4;
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
      <label>Payment Status:</label>

      <select id="checkoutFilter" class="status-select">
        <option value="all">All Records</option>
        <option value="Paid">Paid</option>
        <option value="Pending">Pending</option>
        <option value="Unpaid">Unpaid</option>
      </select>
    </div>

    <button class="btn-add" onclick="window.location.href='addcheckout.php'">
      + Process Checkout
    </button>

  </div>

  <table class="custom-table">

    <thead>
      <tr>
        <th>Checkout ID</th>
        <th>Guest Name</th>
        <th>Room No</th>
        <th>Amount</th>
        <th>Status</th>
        <th style="text-align:center;">Actions</th>
      </tr>
    </thead>

    <tbody id="checkoutTable">

    <?php
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $status = $row["payment_status"];

            if ($status == "Paid") {
                $statusClass = "status-paid";
            } elseif ($status == "Pending") {
                $statusClass = "status-pending";
            } else {
                $statusClass = "status-unpaid";
            }
    ?>

        <tr data-status="<?php echo htmlspecialchars($status); ?>">

          <td>
            <strong>#CO-<?php echo $row["id"]; ?></strong>
          </td>

          <td>
            <?php echo htmlspecialchars($row["Name"]); ?>
          </td>

          <td>
            <?php echo htmlspecialchars($row["room_no"]); ?>
          </td>

          <td>
            $<?php echo number_format($row["amount"], 2); ?>
          </td>

          <td>
            <span class="status-badge <?php echo $statusClass; ?>">
              <?php echo htmlspecialchars($status); ?>
            </span>
          </td>

          <td style="text-align:center;">

            <a
              href="receipt.php?id=<?php echo $row["id"]; ?>"
              class="action-btn btn-process"
              title="Receipt"
            >
              <i class="fa-solid fa-receipt"></i>
            </a>

            <a
              href="editcheckout.php?id=<?php echo $row["id"]; ?>"
              class="action-btn btn-edit"
              title="Edit"
            >
              <i class="fa-solid fa-pen-to-square"></i>
            </a>

            <button
              class="action-btn btn-delete"
              title="Delete"
              onclick="deleteCheckout(<?php echo $row["id"]; ?>)"
            >
              <i class="fa-solid fa-trash"></i>
            </button>

          </td>

        </tr>

    <?php
        }

    } else {
    ?>

        <tr>
          <td colspan="6" style="text-align:center;">
            No checkout records found.
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

document.getElementById("checkoutFilter").addEventListener("change", function() {

    let selected = this.value;

    document.querySelectorAll("#checkoutTable tr").forEach(function(row) {

        let status = row.getAttribute("data-status");

        if (selected === "all" || status === selected) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });

});

function deleteCheckout(id) {

    if (confirm("Are you sure you want to delete this checkout?")) {
        window.location.href = "../database/deletecheckout.php?id=" + id;
    }

}

</script>

</body>
</html>