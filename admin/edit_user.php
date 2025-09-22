<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Database Connection
include '../include/db_conn.php';

// Check if user ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_user.php");
    exit();
}

$user_id = $_GET['id'];

// Fetch user data
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: manage_user.php");
    exit();
}

$user = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update user details
    $updateQuery = "UPDATE users SET name='$name', email='$email', password='$password', phone='$phone', address='$address' WHERE user_id=$user_id";

    if (mysqli_query($conn, $updateQuery)) {
        header("Location: manage_user.php?success=User updated successfully");
        exit();
    } else {
        $error = "Error updating user: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="ASSETS/css/admin_style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px;
            background: #2575fc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #1a5ed8;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include '../include/admin_navbar.php'; ?>

<div class="container">
    <h2>Edit User</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

        <label>Password:</label>
        <input type="text" name="password" value="<?php echo $user['password']; ?>" required>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo $user['address']; ?>" required>

        <button type="submit">Update User</button>
        <a href="manage_user.php" style="display: inline-block; text-align: center; margin-top: 10px; padding: 10px; background: #ccc; color: black; text-decoration: none; border-radius: 5px;">Back</a>
    </form>
</div>


</body>
</html>
