<?php
include "../database/database.php";

$sql = "SELECT * FROM guest ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>HMS - Guest List</title>
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

    .search-input {
      width: 220px;
      padding: 8px 12px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      outline: none;
    }

    .search-input:focus {
      border-color: #000;
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

      <input type="text" class="search-input" id="search" placeholder="Search guests...">

      <button class="btn-add" onclick="window.location.href='addguest.php'">
        + Add Guest
      </button>

    </div>

    <table class="custom-table">

      <thead>
        <tr>
          <th style="width: 60px;">S.No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th style="width: 100px; text-align: center;">Actions</th>
        </tr>
      </thead>

      <tbody id="guestTable">

        <?php
        $serial = 1;

        if ($result->num_rows > 0) {

          while ($guest = $result->fetch_assoc()) {
        ?>

        <tr>
          <td><?php echo $serial++; ?></td>

          <td><?php echo htmlspecialchars($guest["Name"]); ?></td>

          <td><?php echo htmlspecialchars($guest["Email"]); ?></td>

          <td><?php echo htmlspecialchars($guest["phone"]); ?></td>

          <td style="text-align: center;">

            <a href="editguest.php?id=<?php echo $guest["id"]; ?>">
              <button class="action-btn btn-edit">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
            </a>

            <a href="../database/deleteguest.php?id=<?php echo $guest["id"]; ?>"
               onclick="return confirm('Are you sure you want to delete this guest?');">

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
            No guests found
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
    document.getElementById("search").addEventListener("keyup", function() {

      let search = this.value.toLowerCase();

      document.querySelectorAll("#guestTable tr").forEach(function(row) {

        row.style.display = row.innerText.toLowerCase().includes(search)
          ? ""
          : "none";

      });

    });
  </script>

</body>
</html>