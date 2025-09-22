<?php
include 'include/db_conn.php'; // Database connection
include 'include/navbar.php'; // Include navigation

$error = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    if (!empty($name) && !empty($email) && !empty($message)) {
        // Insert data using mysqli_query()
        $sql = "INSERT INTO Contact_Us (name, email, message) VALUES ('$name', '$email', '$message')";
        $execute = mysqli_query($conn, $sql);

        if ($execute) {
            $success = "Message sent successfully!";
        } else {
            $error = "Something went wrong. Please try again!";
        }
    } else {
        $error = "All fields are required!";
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Toy Store</title>
    <link rel="stylesheet" href="ASSETS/css/style.css">
    <style>
        /* Contact Us Page Styling */
        .contact-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }

        .contact-container h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 15px;
        }

        .contact-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }

        .contact-form {
            background: #f8f8f8;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .contact-form label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        .contact-form input, 
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .contact-form button {
            width: 100%;
            padding: 10px;
            background-color: #f1c40f;
            color: black;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .contact-form button:hover {
            background-color: darkgoldenrod;
        }

        .contact-info {
            margin-top: 30px;
            font-size: 16px;
        }

        .contact-info p {
            margin: 5px 0;
        }

        .contact-info a {
            color: #f1c40f;
            text-decoration: none;
        }

        .message-box {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>

<div class="contact-container">
    <h2>Contact <span style="color: #f1c40f;">Toy Store</span></h2>
    <p>If you have any questions or need assistance, feel free to contact us!</p>

    <?php if (!empty($success)): ?>
        <div class="message-box success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="message-box error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="contact-form">
        <form method="POST">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="message">Your Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <div class="contact-info">
        <p><strong>Email:</strong> <a href="mailto:support@toystore.com">support@toystore.com</a></p>
        <p><strong>Phone:</strong> +91 234 567 890</p>
        <p><strong>Address:</strong> 123 Toy Street, Toyland, INDIA</p>
    </div>
</div>

<?php include 'include/footer.php'; ?> <!-- Include footer -->

</body>
</html>
