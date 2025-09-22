<?php
session_start(); // ✅ Required to access session variables
include "../include/db_conn.php";

// ✅ Optional: Protect this page from unauthenticated access
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy Store | Home</title>
    <link rel="stylesheet" href="ASSETS/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Hero Section */
        .hero {
            background: url('../ASSETS/image/home.jpg') no-repeat center center/cover;
            height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: black;
            font-size: 32px;
            font-weight: bold;
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.7);
            padding: 20px;
        }

        /* Featured Products */
        .featured-products {
            text-align: center;
            padding: 10px 20px;
        }

        .products-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .product-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
        }

        .product-card img {
            width: 100%;
            border-radius: 10px;
        }

        .product-card h3 {
            margin: 10px 0;
        }

        .btn {
            background: #f1c40f;
            color: black;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn:hover {
            background: darkgoldenrod;
        }
    </style>
</head>

<body>
    <?php include "../include/user_navbar.php"; ?>

    <section class="hero">
        <h1>Welcome to ToyShop , <?php echo $_SESSION['name']; ?></h1>
        <h1 style="margin-top:-20px;">Welcome to Toy Store - Discover Fun & Adventure!</h1>
    </section>

    <section class="featured-products">
        <h2>Featured Products</h2>
        <div class="products-container">
            <div class="product-card">
                <img src="ASSETS/image/home.jpg" alt="Toy 1">
                <h3>Toy Car</h3>
                <p>$10.99</p>
                <a href="#" class="btn">Buy Now</a>
            </div>
            <div class="product-card">
                <img src="ASSETS/image/home.jpg" alt="Toy 2">
                <h3>Teddy Bear</h3>
                <p>$15.99</p>
                <a href="#" class="btn">Buy Now</a>
            </div>
            <div class="product-card">
                <img src="ASSETS/image/home.jpg" alt="Toy 3">
                <h3>Building Blocks</h3>
                <p>$12.99</p>
                <a href="#" class="btn">Buy Now</a>
            </div>
        </div>
    </section>

    <?php include "../include/footer.php"; ?>
    <Br>
</body>

</html>