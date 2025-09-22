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
    // Check if product already in cart
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");

    if (mysqli_num_rows($check) > 0) {
        // Product already in cart, update quantity +1
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id");
    } else {
        // Product not in cart, insert it
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
    }
}
//  if (isset($_GET['error']) && $_GET['error'] === 'stock_limit'):
//     {
//         alert("⚠️ You have reached the available stock limit.");
//     }

// Redirect back to product or cart page
header("Location: add_to_cart.php");
exit();
?>