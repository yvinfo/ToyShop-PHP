<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
$admin_name = $_SESSION['admin_name'] = 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="ASSETS/css/admin_style.css">
    <style>
        /* Navbar Styles */
        .navbar {
            background: linear-gradient(1000deg, #6a11cb, #2575fc);
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            width: 97.2%; /* Fixed width */
            z-index: 1000;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            font-family: "Arial", sans-serif;
        }

        /* Logo */
        .logo {
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Navigation Links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
            justify-content: center; /* Center the links */
            flex-grow: 1; /* Makes sure it stretches */
            margin-left: 35%;
        }

        .navbar a {
            text-decoration: none;
            color: white;
            font-size: 17px;
            font-weight: bold;
            padding: 8px 15px;
            transition: 0.3s ease-in-out;
            border-radius: 8px;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        /* Logout Button */
        .logout-btn {
            background: #f44336;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: bold;
            margin-left: auto; /* Push logout to the right */
            margin-right: 6%;
        }

        .logout-btn:hover {
            background: #d32f2f;
            transform: scale(1.05);
        }

    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            Welcome, <?php echo $_SESSION['admin_name']; ?>
        </div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="manage_user.php">Users</a>
            <a href="manage_products.php">Products</a>
            <a href="orders.php">Orders</a>
            <a href="reviews.php">Reviews</a>
            <a href="../user/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>
