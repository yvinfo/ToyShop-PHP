<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../include/db_conn.php';

// Fetch all products
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>All Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .product-card {
            flex: 1 1 calc(33.33% - 40px);
            max-width: 300px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: scale(1.02);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background: #f0f0f0;
            padding: 5px;
        }

        .product-details {
            padding: 15px;
            flex-grow: 1;
        }

        .product-details h3 {
            margin: 0;
            font-size: 20px;
            color: #007bff;
        }

        .product-details p {
            margin: 8px 0;
            color: #555;
            font-size: 14px;
        }

        .price {
            font-size: 18px;
            color: #28a745;
            font-weight: bold;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            padding: 0 15px 15px;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 8px 22px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn.wishlist {
            background-color: #ffc107;
            color: #000;
        }

        .btn.wishlist:hover {
            background-color: #e0a800;
        }

        @media (max-width: 768px) {
            .product-card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>

<body>

    <?php include "../include/user_navbar.php"; ?>

    <div class="product-container">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="product-card">
                <img src="../uploads/<?php echo $row['image']; ?>" alt="Product Image">
                <div class="product-details">
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <p class="price">₹<?php echo $row['price']; ?></p>
                </div>
                <div class="button-group">
                    <!-- Cart Form -->
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <button type="submit" class="btn">Add to Cart</button>
                    </form>
                    <!-- Wishlist Form -->
                    <form method="POST" action="add_to_wishlist.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <button type="submit" class="btn wishlist">Add to Wishlist</button>
                    </form>

                </div>
            </div>
        <?php } ?>
    </div>

    <?php include "../include/footer.php"; ?>
</body>

</html>