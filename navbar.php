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
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>