<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if it's not already active
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy Store - User Dashboard</title>
    <link rel="stylesheet" href="ASSETS/css/style.css">
    <style>
        /* Navbar Styles */
        .navbar {
            background: linear-gradient(45deg, #ffcc00, #ff6699);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            width: 97.3%;
            z-index: 1000;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        /* Logo (Left Side) */
        .logo img {
            height: 40px; /* Adjust as needed */
        }

    /* Move navigation links slightly to the left */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 40px;
            margin-right: auto; /* Push links toward the left */
            margin-left: 48%;  /* Adjust left positioning */
        }


        /* Navbar links */
        .navbar a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            padding: 5px 10px;
            transition: 0.3s ease-in-out;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Hide checkbox */
        .dropdown input {
            display: none;
        }

        /* Label to trigger dropdown */
        .dropdown label {
            cursor: pointer;
            color: white;
            padding: 5px 10px;
            display: block;
        }

        /* Dropdown Content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 180px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            top: 40px;
            right: 0;
        }

        .dropdown-content a {
            display: flex;
            align-items: center;
            padding: 10px;
            color: black;
            transition: 0.3s ease-in-out;
        }

        .dropdown-content a:hover {
            background: #f4f4f4;
        }

        /* Show dropdown when checkbox is checked */
        .dropdown input:checked ~ .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">
            <a href="home.php"><img src="../ASSETS/image/home.jpg" alt="Toy Store Logo"></a>
        </div>
        <div class="nav-links">
            <a href="userhome.php">Home</a>
            <a href="product_details.php">Product Details</a>
            <a href="cart.php">Shopping Cart</a>
            
            <!-- Clickable Dropdown -->
            <div class="dropdown">
                <input type="checkbox" id="account-toggle">
                <label for="account-toggle">Account &#9660;</label>
                <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="../user/wishlist.php">Wish List</a>
                    <a href="../user/change_password.php">Change Password</a>
                    <a href="orders.php">Order History</a>
                </div>
            </div>

            <a href="../user/logout.php">Logout</a>
        </div>
    </div>

</body>
</html>
