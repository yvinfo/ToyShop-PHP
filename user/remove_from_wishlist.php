<?php
session_start();
include '../include/db_conn.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? 0;

if ($product_id > 0) {
    $delete = mysqli_query($conn, "DELETE FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
    if (!$delete) {
        echo "Error deleting from wishlist: " . mysqli_error($conn);
        exit();
    }
}

// Redirect back to wishlist page
header("Location: wishlist.php");
exit();
