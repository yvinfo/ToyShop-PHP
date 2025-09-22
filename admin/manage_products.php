<?php
// Database Connection
include '../include/db_conn.php';

$search = "";
$stock_filter = "";
// Search and Filter Logic
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
}

if (!empty($_GET['stock_filter'])) {
    $stock_filter = $_GET['stock_filter'];
}

$sql = "SELECT * FROM Products WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND name LIKE '%$search%'";
}
if ($stock_filter === 'in_stock') {
    $sql .= " AND stock > 0";
} elseif ($stock_filter === 'out_of_stock') {
    $sql .= " AND stock = 0";
}

$result = mysqli_query($conn, $sql);



// Handle Delete product
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $delete_sql = "DELETE FROM Products WHERE product_id = '$delete_id'";
    mysqli_query($conn, $delete_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="ASSETS/css/admin_style.css">
    <style>
                /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        /* Form Styles */
        form {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input, textarea,select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            color: white;
            background: #2575fc;
            font-size: 16px;
        }

        button:hover {
            background: #1a5bbf;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #2575fc;
            font-weight: bold;
        }

        a:hover {
            color: #1a5bbf;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #2575fc;
            color: white;
        }

        /* Image Styling */
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        /* Buttons */
        .btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            display: inline-block;
        }

        .btn-add {
            background: #2575fc;
        }

        .btn-delete {
            background: #d9534f;
        }

        .btn-edit {
            background: #f0ad4e;
        }

        .btn-back {
            background: #555;
            margin-bottom: 10px;
            display: inline-block;
        }

    </style>
</head>
<body>
<?php include '../include/admin_navbar.php'; ?>
    <div class="container">
        <h2>Product List</h2>
        <a href="add_product.php" class="btn btn-add">&#10133; Add New Product</a>
        
        <!-- Search and Filter Form -->
      <!-- Search and Filter Form -->
        <form method="GET">
            <input type="text" name="search" placeholder="Search by name" value="<?php echo $search; ?>">
            <select name="stock_filter">
                <option value="">All</option>
                <option value="in_stock" <?php if ($stock_filter == 'in_stock') echo 'selected'; ?>>In Stock</option>
                <option value="out_of_stock" <?php if ($stock_filter == 'out_of_stock') echo 'selected'; ?>>Out of Stock</option>
            </select>
            <button type="submit">Filter</button>
        </form>


        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>&#8377;<?php echo $row['price']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td><img src="../uploads/<?php echo $row['image']; ?>" width="50"></td>
                    <td >
                        <a href="edit_product.php?id=<?php echo $row['product_id'];?>" class="btn btn-edit">Edit</a>
                        <a href="manage_products.php?delete_id=<?php echo $row['product_id']; ?>" class="btn btn-delete"
                                    onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
