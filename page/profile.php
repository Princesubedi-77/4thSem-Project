<?php
session_start();
include "../database/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.html");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM USER WHERE USER_ID = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "User not found";
    exit();
}

$user = $result->fetch_assoc();

$first_name = $user["First_Name"];
$last_name = $user["Last_Name"];
$email = $user["Email"];
$role = $user["role"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HMS - Profile</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff;
      margin: 0;
    }

    .container {
      max-width: 700px;
      margin: 100px auto 40px;
      padding: 0 20px;
    }

    .profile {
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 30px;
    }

    h2 {
      margin: 0 0 25px;
      font-size: 24px;
    }

    .profile-info {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .info {
      border-bottom: 1px solid #ddd;
      padding-bottom: 12px;
    }

    .info label {
      display: block;
      font-size: 13px;
      color: #666;
      margin-bottom: 6px;
    }

    .info p {
      margin: 0;
      font-size: 15px;
      font-weight: bold;
    }

    .role {
      display: inline-block;
      background: #f1f5f9;
      border: 1px solid #cbd5e1;
      padding: 5px 12px;
      border-radius: 12px;
      font-size: 13px;
    }

    .actions {
      display: flex;
      gap: 10px;
      margin-top: 25px;
    }

    .btn {
      padding: 10px 18px;
      border: 0;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    .edit {
      background: #000;
      color: #fff;
    }

    .logout {
      background: #555;
      color: #fff;
    }

    .delete {
      background: #dc2626;
      color: #fff;
    }

    .btn:hover {
      opacity: 0.85;
    }

    #editProfile {
      display: none;
      margin-top: 25px;
      border-top: 1px solid #ddd;
      padding-top: 25px;
    }

    .edit-form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px;
    }

    .edit-form div {
      display: flex;
      flex-direction: column;
    }

    .edit-form label {
      font-size: 13px;
      color: #555;
      margin-bottom: 7px;
    }

    .edit-form input,
    .edit-form select {
      width: 100%;
      height: 40px;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      outline: none;
      background: #fff;
      color: #000;
      font-size: 14px;
    }

    .edit-form input:focus,
    .edit-form select:focus {
      border-color: #000;
    }

    .edit-form select {
      cursor: pointer;
    }

    .edit-actions {
      display: flex;
      gap: 10px;
      margin-top: 25px;
    }

    .save {
      background: #000;
      color: #fff;
    }

    .cancel {
      background: #eee;
      color: #000;
    }

    @media (max-width: 600px) {
      .profile-info,
      .edit-form {
        grid-template-columns: 1fr;
      }

      .actions {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>

  <div id="navbar"></div>

  <div class="container">

    <div class="profile">

      <h2>Profile</h2>

      <div class="profile-info">

        <div class="info">
          <label>First Name</label>
          <p><?php echo htmlspecialchars($first_name); ?></p>
        </div>

        <div class="info">
          <label>Last Name</label>
          <p><?php echo htmlspecialchars($last_name); ?></p>
        </div>

        <div class="info">
          <label>Email</label>
          <p><?php echo htmlspecialchars($email); ?></p>
        </div>

        <div class="info">
          <label>Role</label>
          <span class="role"><?php echo htmlspecialchars($role); ?></span>
        </div>

      </div>

      <div class="actions">
        <button class="btn edit" onclick="showEditProfile()">Edit Profile</button>
        <button class="btn logout" onclick="logout()">Logout</button>
        <button class="btn delete" onclick="deleteAccount()">Delete Account</button>
      </div>

      <div id="editProfile">

        <h2>Edit Profile</h2>

        <form action="../database/updateprofile.php" method="POST">

          <div class="edit-form">

            <div>
              <label>First Name</label>
              <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
            </div>

            <div>
              <label>Last Name</label>
              <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
            </div>

            <div>
              <label>Email</label>
              <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div>
              <label>New Password</label>
              <input type="password" name="password" placeholder="Enter new password">
            </div>

            <div>
              <label>Confirm Password</label>
              <input type="password" name="confirm_password" placeholder="Confirm new password">
            </div>

            <div>
              <label>Role</label>

              <select name="role">

                <option value="Admin" <?php if ($role == "Admin") echo "selected"; ?>>Admin</option>

                <option value="Manager" <?php if ($role == "Manager") echo "selected"; ?>>Manager</option>

                <option value="Receptionist" <?php if ($role == "Receptionist") echo "selected"; ?>>Receptionist</option>

                <option value="Housekeeping" <?php if ($role == "Housekeeping") echo "selected"; ?>>Housekeeping</option>

                

              </select>

            </div>

          </div>

          <div class="edit-actions">
            <button class="btn save" type="submit">Save Changes</button>
            <button class="btn cancel" type="button" onclick="hideEditProfile()">Cancel</button>
          </div>

        </form>

      </div>

    </div>

  </div>

  <script src="navbar.js"></script>

  <script>
    function showEditProfile() {
      document.getElementById("editProfile").style.display = "block";
    }

    function hideEditProfile() {
      document.getElementById("editProfile").style.display = "none";
    }

    function logout() {
      if (confirm("Are you sure you want to logout?")) {
        window.location.href = "../database/logout.php";
      }
    }

    function deleteAccount() {
      if (confirm("Are you sure you want to delete your account?")) {
        window.location.href = "../database/deleteaccount.php";
      }
    }
  </script>

</body>
</html>