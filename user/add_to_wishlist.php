<?php
session_start();
include '../include/db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? 0;

if ($product_id > 0) {
    // Prevent duplicate entry
    $check = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
    if (mysqli_num_rows($check) == 0) {
        $insert = mysqli_query($conn, "INSERT INTO wishlist (user_id, product_id) VALUES ($user_id, $product_id)");
        if (!$insert) {
            die("Error: " . mysqli_error($conn));
        }
    }
}

header("Location: wishlist.php");
exit();
