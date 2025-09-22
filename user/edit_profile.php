<?php
session_start();
include '../include/db_conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT name, email, phone, address FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found!";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Update user details
    $update_sql = "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address' WHERE user_id='$user_id'";
    if (mysqli_query($conn, $update_sql)) {
        header("Location: profile.php?success=Profile updated successfully");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Toy Store</title>
    <link rel="stylesheet" href="ASSETS/css/style.css">
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .edit-profile-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .edit-profile-container h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            text-align: left;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            height: 100px;
            resize: none;
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

<div class="edit-profile-container">
    <h2>Edit Profile</h2>
    <form action="" method="POST" onsubmit="return confirmUpdate()">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>

        <label for="address">Address</label>
        <textarea id="address" name="address" required><?php echo $user['address']; ?></textarea>

        <button type="submit" class="save-btn">Save Changes</button>
    </form>
    <a href="profile.php" class="back-btn">&#8592; Back to Profile</a>
</div>

<?php include "../include/footer.php"; ?>

<script>
    function confirmUpdate() {
        return confirm("Are you sure you want to update your profile?");
    }
</script>

</body>
</html>
