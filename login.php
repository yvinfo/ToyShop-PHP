<?php
session_start(); // Start session

include 'include/db_conn.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Email and password are required!";
    } else {
        // Admin login check
        if ($email === "admin@admin.com" && $password === "admin1234") {
            $_SESSION['admin'] = true;
            header("Location: admin/admin-dashboard.php");
            exit();
        }

        // Query to check user credentials
        $sql = "SELECT * FROM Users WHERE email = '$email' AND password = '$password'";
        $res = mysqli_query($conn, $sql);

        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            
            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];
            header("Location: ./user/userhome.php");
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="ASSETS/css/login.css">
</head>
<body>
    <?php include "include/navbar.php"; ?>

    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn">Login</button>
                <?php if (!empty($error)): ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>

    <?php include "include/footer.php"; ?>
</body>
</html>
