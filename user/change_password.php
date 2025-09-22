<?php
session_start();
include '../include/db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Fetch the existing password from the database
    $sql = "SELECT password FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // Validate current password
    if (!$user || $user['password'] !== $current_password) {  // No password_verify() used
        $message = "Current password is incorrect!";
    } elseif (strlen($new_password) < 6) {
        $message = "New password must be at least 6 characters!";
    } elseif ($new_password !== $confirm_password) {
        $message = "New passwords do not match!";
    } else {
       
        $update_sql = "UPDATE users SET password='$new_password' WHERE user_id='$user_id'";

        if (mysqli_query($conn, $update_sql)) {
            $message = "Password changed successfully!";
        } else {
            $message = "Error updating password.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Toy Store</title>
    <link rel="stylesheet" href="ASSETS/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .change-password-container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .change-password-container h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        form {
            text-align: left;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .save-btn {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background-color: #f1c40f;
            color: black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .save-btn:hover {
            background-color: darkgoldenrod;
        }

        .back-btn {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            text-decoration: none;
            color: #555;
        }

        .back-btn:hover {
            color: #333;
        }

    </style>
</head>
<body>

<?php include '../include/user_navbar.php'; ?>

<div class="change-password-container">
    <h2>Change Password</h2>
    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
    <form action="" method="POST" onsubmit="return confirmChange()">
        <label for="current_password">Current Password</label>
        <input type="password" id="current_password" name="current_password" required>

        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" class="save-btn">Change Password</button>
    </form>
    <a href="userhome.php" class="back-btn">&#8592; Back to Home</a>
</div>

<?php include "../include/footer.php"; ?>

<script>
    function confirmChange() {
        return confirm("Are you sure you want to change your password?");
    }
</script>

</body>
</html>
