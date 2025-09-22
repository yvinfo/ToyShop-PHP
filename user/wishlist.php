<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../include/db_conn.php';
$user_id = $_SESSION['user_id'];

// Fetch wishlist items with product details
$query = "
    SELECT p.* 
    FROM wishlist w
    JOIN products p ON w.product_id = p.product_id
    WHERE w.user_id = $user_id
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Wishlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin: 20px;
            color: #333;
        }

        .wishlist-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .wishlist-card {
            background: #fff;
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease;
        }

        .wishlist-card:hover {
            transform: scale(1.02);
        }

        .wishlist-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background: #f0f0f0;
            padding: 5px;
        }

        .wishlist-details {
            padding: 15px;
            flex-grow: 1;
        }

        .wishlist-details h3 {
            margin: 0;
            font-size: 20px;
            color: #007bff;
        }

        .wishlist-details p {
            margin: 8px 0;
            color: #555;
            font-size: 14px;
        }

        .price {
            font-size: 18px;
            color: #28a745;
            font-weight: bold;
        }

        .remove-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            margin: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<?php include "../include/user_navbar.php"; ?>
<h2>My Wishlist</h2>

<div class="wishlist-container">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="wishlist-card">
                <img src="../uploads/<?php echo $row['image']; ?>" alt="Product Image">
                <div class="wishlist-details">
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <p class="price">₹<?php echo $row['price']; ?></p>
                </div>
                <form method="POST" action="remove_from_wishlist.php">
                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                    <button type="submit" class="remove-btn">Remove</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">Your wishlist is empty.</p>
    <?php endif; ?>
</div>

<?php include "../include/footer.php"; ?>
</body>
</html>
