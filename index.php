<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Store</title>
    <link rel="stylesheet" href="main_page_styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="index.php" class="logo">Online Store</a>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <?php if (isset($_SESSION["user_id"])) : ?>
                        <li><a href="logout.php">Logout</a></li>
                        <?php if ($_SESSION["role"] == "admin") : ?>
                            <li><a href="admin_panel.php">Admin Panel</a></li>
                        <?php endif; ?>
                    <?php else : ?>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropbtn">Register</a>
                            <div class="dropdown-content">
                                <a href="register.php">User Register</a>
                                <a href="register.php?admin=true">Admin Register</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropbtn">Login</a>
                            <div class="dropdown-content">
                                <a href="login.php">User Login</a>
                                <a href="login.php?admin=true">Admin Login</a>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <section class="hero">
            <h1>Welcome to Our Online Store!</h1>
            <p>Find the best products at amazing prices.</p>
            <a href="products.php" class="btn">Shop Now</a>
        </section>

        <section class="featured-products">
            <h2>Featured Products</h2>
            <p>Featured Products will be loaded from database here.</p>
        </section>

        <section class="about-us">
            <h2>About Us</h2>
            <p>We are a leading online store providing high-quality products and excellent customer service.</p>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Online Store. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>