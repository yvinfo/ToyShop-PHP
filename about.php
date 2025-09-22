<?php include 'include/navbar.php'; ?> <!-- Include navigation -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Toy Store</title>
    <link rel="stylesheet" href="ASSETS/css/style.css">
    <style>
        /* About Us Page Styling */
        .about-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }

        .about-container h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 15px;
        }

        .about-container p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 20px;
        }

        .about-container img {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 20px;
        }

        .highlight {
            color: #f1c40f;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="about-container">
    <h2>Welcome to <span class="highlight">Toy Store</span></h2>
    <p>At <strong>Toy Store</strong>, we believe in bringing joy to children through high-quality and safe toys. 
    We offer a wide range of toys designed to spark imagination, creativity, and endless fun.</p>

    <p>Our journey started with a mission: <span class="highlight">to create magical moments for kids</span>. 
    From classic toys to the latest trends, we carefully curate our collection to ensure excitement for all ages.</p>

    <img src="ASSETS/image/home.jpg" alt="About Us - Toy Store">

    <p>We are committed to customer satisfaction and providing top-notch service. Thank you for choosing Toy Store – 
    where happiness begins!</p>
</div>

<?php include 'include/footer.php'; ?> <!-- Include footer -->

</body>
</html>
