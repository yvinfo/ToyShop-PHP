<?php

?>

<html>
    <head>
        <style>
            /* Basic Navbar Styling */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #333;
    padding: 15px 20px;
}

.logo a {
    color: #fff;
    font-size: 24px;
    text-decoration: none;
    font-weight: bold;
}

.nav-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
}

.nav-links li {
    margin: 0 15px;
}

.nav-links a {
    text-decoration: none;
    color: white;
    font-size: 18px;
    padding: 8px 12px;
    transition: background 0.3s ease;
}

.nav-links a:hover {
    background: #f1c40f;
    border-radius: 5px;
}

        </style>
    </head>
<body>
    <nav class="navbar">
        <div class="logo">
           <a href="index.php">Toy Store</a>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</body>



</html>
