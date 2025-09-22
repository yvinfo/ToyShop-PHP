<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Database Connection
include '../include/db_conn.php';
$error = "";

// Get product ID from URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
} else {
    header("Location: view_products.php");
    exit();
}

$name = '';
$description = '';
$stock = '';
$price = '';
$image = '';

// Fetch existing product data
$sql = "SELECT * FROM Products WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: view_products.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Image Upload Handling (If a new image is uploaded)
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];

    $image_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $allowed_types = ["jpg", "jpeg", "png", "gif"];

    // Validate file type
    if (!empty($image_name) && !in_array($image_type, $allowed_types)) {
        $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
    } 
    // Validate file size (optional: limit size to 2MB)
    elseif ($image_size > 2 * 1024 * 1024) {
        $error = "File size must be less than 2MB.";
    } 
    else {
        // If a new image is uploaded, upload it
        if (!empty($image_name)) {
            // Generate a unique name for the image
            $new_image_name = uniqid() . "." . $image_type;

            // Upload the new image
            $upload_path = "../uploads/" . $new_image_name;
            if (move_uploaded_file($image_tmp, $upload_path)) {
                // Delete old image file if it's different from the new one
                if ($product['image'] && file_exists("../uploads/" . $product['image'])) {
                    unlink("../uploads/" . $product['image']);
                }
            } else {
                $error = "Error uploading the image.";
            }
        } else {
            // If no new image is uploaded, retain the old image
            $new_image_name = $product['image'];
        }

        // Update the product in the database
        if (empty($error)) {
            $sql_update = "UPDATE Products 
                           SET name = '$name', description = '$description', price = '$price', stock = '$stock', image = '$new_image_name' 
                           WHERE product_id = '$product_id'";

            if (mysqli_query($conn, $sql_update)) {
                header("Location: manage_products.php"); // Redirect to product list
                exit();
            } else {
                $error = "Error updating product: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
            width: 60%;
            margin: 50px auto;
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
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, textarea {
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

        /* Image Styling */
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include '../include/admin_navbar.php'; ?>

<div class="container">
    <h2>Edit Product</h2>

    <!-- Display Error Message -->
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" value="<?php echo $product['name']; ?>" required>
        <textarea name="description" placeholder="Product Description"><?php echo $product['description']; ?></textarea>
        <input type="number" name="price" step="0.01" placeholder="Price" value="<?php echo $product['price']; ?>" required>
        <input type="number" name="stock" placeholder="Stock Quantity" value="<?php echo $product['stock']; ?>" required>
        
        <div>
            <label>Current Product Image</label>
            <img src="../uploads/<?php echo $product['image']; ?>" alt="Product Image">
            <input type="file" name="image" accept="image/*">
            <small>Leave empty if you don't want to change the image.</small>
        </div>

        <button type="submit">Update Product</button>
    </form>

    <a href="manage_products.php" class="btn btn-back">Back to Product List</a>
</div>

</body>
</html>
