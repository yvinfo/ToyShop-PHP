<?php
session_start();
include '../include/db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    // Get current quantity from cart
    $query = "SELECT quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $result = mysqli_query($conn, $query);
    $cart = mysqli_fetch_assoc($result);

    if (!$cart) {
        header("Location: cart.php?error=invalid_cart");
        exit();
    }

    $quantity = $cart['quantity'];

    // Get available stock
    $stock_result = mysqli_query($conn, "SELECT stock FROM products WHERE product_id = $product_id");
    $stock_row = mysqli_fetch_assoc($stock_result);
    $stock = $stock_row['stock'];

    if ($action === "increase") {
        if ($quantity < $stock) {
            $quantity++;
            mysqli_query($conn, "UPDATE cart SET quantity = $quantity WHERE user_id = $user_id AND product_id = $product_id");
        } else {
            // Redirect with error
            header("Location: cart.php?error=stock_limit");
            exit();
        }

    } elseif ($action === "decrease") {
        if ($quantity > 1) {
            $quantity--;
            mysqli_query($conn, "UPDATE cart SET quantity = $quantity WHERE user_id = $user_id AND product_id = $product_id");
        }
    }
}

header("Location: cart.php");
exit();
