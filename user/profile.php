<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}
include '../include/db_conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

$user_id = $_SESSION['user_id']; 


if (!is_numeric($user_id)) {
    die("Invalid user ID!");
}


$sql = "SELECT name, email, phone, address FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

// Check if query was successful
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Toy Store</title>
    <link rel="stylesheet" href="ASSETS/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-container h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .profile-info {
            text-align: left;
            font-size: 16px;
            color: #555;
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .profile-info p {
            margin: 8px 0;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .profile-info p:last-child {
            border-bottom: none;
        }

        .edit-btn {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #f1c40f;
            color: black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .edit-btn:hover {
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
    <div class="profile-container">
        <h2>Welcome, <?php echo $user['name']; ?>!</h2>
        <div class="profile-info">
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
            <p><strong>Address:</strong> <?php echo $user['address']; ?></p>
        </div>
        <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
        <a href="../user/userhome.php" class="back-btn">&#8592; Back to Home</a>
    </div>
    <?php include "../include/footer.php"; ?>
</body>
</html>
