<?php
session_start();
include '../include/db_conn.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Toy Store</title>
    <link rel="stylesheet" href="ASSETS/css/admin_style.css">
</head>
<body>

<?php include '../include/admin_navbar.php'; ?>


</body>
</html>
