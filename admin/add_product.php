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

// Handle Product Addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    
    // Image Upload Handling
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];

    $image_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $allowed_types = ["jpg", "jpeg", "png", "gif"];

    // Validate file type
    if (!in_array($image_type, $allowed_types)) {
        $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
    } 
    // Validate file size (optional: limit size to 2MB)
    elseif ($image_size > 2 * 1024 * 1024) {
        $error = "File size must be less than 2MB.";
    } 
    else{
        $upload_path = "../uploads/" . $image_name;
        move_uploaded_file($image_tmp, $upload_path);
        
        // Insert into Database (Without Prepared Statement)
    $sql = "INSERT INTO Products (name, description, price, stock, image) 
    VALUES ('$name', '$description', '$price', '$stock', '$image_name')";

        if (mysqli_query($conn, $sql)) {
        header("Location: manage_products.php"); // Redirect to the product list
        exit(); 
        } else {
        echo "Error: " . mysqli_error($conn);
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    
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
        .error {
            color: red;
            font-weight: bold;
        }

    </style>
</head>
<body>

<?php include '../include/admin_navbar.php'; ?>

<div class="container">
    <h2>Add New Product</h2>

 <!-- Display Error Message -->
 <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data"> <!-- Allow file upload -->
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Product Description"></textarea>
        <input type="number" name="price" step="0.01" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock Quantity" required>
        <input type="file" name="image" accept="image/*" required> <!-- File Upload -->
        <button type="submit">Add Product</button>
    </form>
    <a href="manage_products.php" class="btn btn-add">View Products</a>
</div>

</body>
</html>
