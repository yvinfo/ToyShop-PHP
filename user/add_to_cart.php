<?php
session_start();
include '../include/db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "
    SELECT c.*, p.name, p.price, p.image
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = $user_id
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Cart</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }

        /* Layout sections */
        .cart-wrapper {
            display: flex;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            gap: 20px;
        }

        .left-section {
            flex: 2;
        }

        .right-section {
            flex: 1;
            border-left: 1px solid #ccc;
            padding-left: 20px;
        }

        /* Cart item display */
        .cart-item {
            display: flex;
            border-bottom: 1px solid #ddd;
            padding: 20px 0;
        }

        .cart-item img {
            width: 120px;
            height: 160px;
            object-fit: cover;
            border: 1px solid #eee;
            margin-right: 20px;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-details h4 {
            margin: 0 0 5px;
            font-size: 18px;
        }

        .item-details p {
            margin: 4px 0;
            font-size: 14px;
            color: #555;
        }

        .price,
        .total {
            font-weight: bold;
            margin-top: 10px;
            font-size: 16px;
        }

        /* Quantity button form */
        .qty-form {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        .qty-form button {
            width: 28px;
            height: 28px;
            font-size: 18px;
            font-weight: bold;
            border: 1px solid #ccc;
            background: #f4f4f4;
            cursor: pointer;
        }

        .qty-form input[type="text"] {
            width: 30px;
            text-align: center;
            border: none;
            background: transparent;
            font-size: 16px;
        }

        /* Item actions */
        .item-actions button {
            background: none;
            border: none;
            color: #007bff;
            margin-right: 10px;
            cursor: pointer;
        }

        /* Summary box */
        .summary-box {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
        }

        .summary-box input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }

        .summary-box .summary-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .checkout-btn {
            width: 100%;
            padding: 12px;
            background: #ffc107;
            border: none;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>

</head>

<body>

    <?php include "../include/user_navbar.php"; ?>
  
    <h2>🛒 My Cart</h2>

    <div class="cart-wrapper">
        <div class="left-section">
            <?php
            $total = 0;
            if (mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)):
                    $subTotal = $row['price'] * $row['quantity'];
                    $total += $subTotal;
            ?>
                    <div class="cart-item">
                        <img src="../uploads/<?php echo $row['image']; ?>" alt="Product">
                        <div class="item-details">
                            <h4><?php echo $row['name']; ?></h4>
                            <p>Color: Default</p>
                            <p>Size: <?php echo $row['size'] ?? 'M'; ?></p>
                            <p>In Stock</p>

                            <form method="POST" action="update_cart_quantity.php" class="qty-form">
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                <input type="hidden" name="quantity" value="<?php echo $row['quantity']; ?>">
                                <button type="submit" name="action" value="decrease">-</button>
                                <input type="text" value="<?php echo $row['quantity']; ?>" readonly>
                                <button type="submit" name="action" value="increase">+</button>
                            </form>

                            <p class="price">Each: ₹<?php echo number_format($row['price'], 2); ?></p>
                            <p class="total">Total: ₹<?php echo number_format($subTotal, 2); ?></p>

                            <div class="item-actions">
                                <form action="remove_from_cart.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <p style="padding: 20px;">Your cart is empty.</p>
            <?php endif; ?>
        </div>

        <div class="right-section">
            <div class="summary-box">
                <h3>Enter Promo Code</h3>
                <input type="text" placeholder="Promo Code">
                <button class="checkout-btn">Submit</button>

                <div class="summary-line"><span>Shipping cost</span><span>TBD</span></div>
                <div class="summary-line"><span>Discount</span><span>- ₹0</span></div>
                <div class="summary-line"><span>Tax</span><span>TBD</span></div>
                <hr>
                <div class="summary-line"><strong>Estimated Total</strong><strong>₹<?php echo number_format($total, 2); ?></strong></div>

                <button class="checkout-btn">Checkout</button>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>
</body>

</html>