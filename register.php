<?php
include 'include/db_conn.php';
 include "include/navbar.php";  // Include database connection file

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long!";
    } 
    elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "Phone number must be exactly 10 digits!";
    }else {
        // SQL query (without password hashing)
        $sql = "INSERT INTO Users (name, email, password, phone, address) VALUES ('$name', '$email', '$password', '$phone', '$address')";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: Email already exists or another issue occurred.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="ASSETS/css/login.css">
</head>
<body>

    <div class="container">
        <div class="form-container">
            <h2>Register</h2>
           
            <form method="POST" action="">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="text" name="phone" placeholder="Phone Number">
                <textarea name="address" placeholder="Address"></textarea>
                <button type="submit" class="btn">Register</button>
               <?php if ($error): ?>
                <p style="color: red;"> <?php echo $error; ?> </p>
            <?php endif; ?>
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>

    <?php include "include/footer.php"; ?>
</body>
</html>
