<?php
include "../database/database.php";

$id = $_GET["id"];

$sql = "SELECT * FROM staff WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Staff not found";
    exit();
}

$staff = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $role = $_POST["role"];

    $sql = "UPDATE staff SET
            name = '$name',
            email = '$email',
            phone = '$phone',
            role = '$role'
            WHERE id = '$id'";

    if ($conn->query($sql)) {
        header("Location: staff.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Staff</title>

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

.form-group {
    margin-bottom: 18px;
}

label {
    display: block;
    font-size: 13px;
    margin-bottom: 7px;
    color: #555;
}

input,
select {
    width: 100%;
    height: 40px;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: #fff;
}

input:focus,
select:focus {
    outline: none;
    border-color: #000;
}

.buttons {
    display: flex;
    gap: 10px;
    margin-top: 25px;
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
}

</style>

</head>

<body>

<div id="navbar"></div>

<div class="container">

<h2>Edit Staff</h2>

<form method="POST">

    <div class="form-group">
        <label>Name</label>

        <input type="text"
               name="name"
               value="<?php echo htmlspecialchars($staff["name"]); ?>"
               required>
    </div>

    <div class="form-group">
        <label>Email</label>

        <input type="email"
               name="email"
               value="<?php echo htmlspecialchars($staff["email"]); ?>"
               required>
    </div>

    <div class="form-group">
        <label>Phone</label>

        <input type="text"
               name="phone"
               value="<?php echo htmlspecialchars($staff["phone"]); ?>"
               required>
    </div>

    <div class="form-group">

        <label>Role</label>

        <select name="role" required>

            <option value="Manager" <?php if ($staff["role"] == "Manager") echo "selected"; ?>>
                Manager
            </option>

            <option value="Receptionist" <?php if ($staff["role"] == "Receptionist") echo "selected"; ?>>
                Receptionist
            </option>

            <option value="Housekeeping" <?php if ($staff["role"] == "Housekeeping") echo "selected"; ?>>
                Housekeeping
            </option>

            <option value="Chef" <?php if ($staff["role"] == "Chef") echo "selected"; ?>>
                Chef
            </option>

            <option value="Cook" <?php if ($staff["role"] == "Cook") echo "selected"; ?>>
                Cook
            </option>

            <option value="Waiter" <?php if ($staff["role"] == "Waiter") echo "selected"; ?>>
                Waiter
            </option>

            <option value="Room Service" <?php if ($staff["role"] == "Room Service") echo "selected"; ?>>
                Room Service
            </option>

            <option value="Maintenance" <?php if ($staff["role"] == "Maintenance") echo "selected"; ?>>
                Maintenance
            </option>

            <option value="Security" <?php if ($staff["role"] == "Security") echo "selected"; ?>>
                Security
            </option>

            <option value="Accountant" <?php if ($staff["role"] == "Accountant") echo "selected"; ?>>
                Accountant
            </option>

        </select>

    </div>

    <div class="buttons">

        <button class="save" type="submit">
            Save Changes
        </button>

        <button class="cancel"
                type="button"
                onclick="window.location.href='staff.php'">
            Cancel
        </button>

    </div>

</form>

</div>

<script src="navbar.js"></script>

</body>
</html>