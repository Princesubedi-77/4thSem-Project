<?php
include "../database/database.php";

$role = $_GET["role"] ?? "all";

if ($role == "all") {
    $sql = "SELECT * FROM staff ORDER BY id DESC";
} else {
    $role = $conn->real_escape_string($role);
    $sql = "SELECT * FROM staff WHERE role = '$role' ORDER BY id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>HMS - Staff Management</title>

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

    .role-select {
      padding: 8px 12px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      outline: none;
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

    .role-badge {
      background: #f1f5f9;
      border: 1px solid #cbd5e1;
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 13px;
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

      <label for="roleFilter">Filter by Role:</label>

      <select id="roleFilter" class="role-select">
        <option value="all">All Roles</option>
        <option value="Manager">Manager</option>
        <option value="Receptionist">Receptionist</option>
        <option value="Housekeeping">Housekeeping</option>
        <option value="Chef">Chef</option>
        <option value="Cook">Cook</option>
        <option value="Waiter">Waiter</option>
        <option value="Room Service">Room Service</option>
        <option value="Maintenance">Maintenance</option>
        <option value="Security">Security</option>
        <option value="Accountant">Accountant</option>
      </select>

    </div>

    <button class="btn-add" onclick="window.location.href='addstaff.php'">
      + Add Staff
    </button>

  </div>

  <table class="custom-table">

    <thead>
      <tr>
        <th style="width: 60px;">S.No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Role</th>
        <th style="width: 100px; text-align: center;">Actions</th>
      </tr>
    </thead>

    <tbody>

    <?php

    $serial = 1;

    if ($result->num_rows > 0) {

      while ($staff = $result->fetch_assoc()) {

    ?>

      <tr>

        <td><?php echo $serial++; ?></td>

        <td><?php echo htmlspecialchars($staff["name"]); ?></td>

        <td><?php echo htmlspecialchars($staff["email"]); ?></td>

        <td><?php echo htmlspecialchars($staff["phone"]); ?></td>

        <td>
          <span class="role-badge">
            <?php echo htmlspecialchars($staff["role"]); ?>
          </span>
        </td>

        <td style="text-align: center;">

          <a href="editstaff.php?id=<?php echo $staff["id"]; ?>">
            <button class="action-btn btn-edit">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>
          </a>

          <a href="../database/deletestaff.php?id=<?php echo $staff["id"]; ?>"
             onclick="return confirm('Are you sure you want to delete this staff member?');">

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
        <td colspan="6" style="text-align:center;">
          No staff found
        </td>
      </tr>

    <?php } ?>

    </tbody>

  </table>

</div>

<script src="navbar.js"></script>

<script>

document.getElementById("roleFilter").value =
  "<?php echo htmlspecialchars($role); ?>";

document.getElementById("roleFilter").addEventListener("change", function() {

  window.location.href = "staff.php?role=" + encodeURIComponent(this.value);

});

</script>

</body>
</html>