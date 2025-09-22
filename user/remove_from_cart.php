<?php
session_start();
include '../include/db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

$delete = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
mysqli_query($conn, $delete);

header("Location: add_to_cart.php");
exit();
