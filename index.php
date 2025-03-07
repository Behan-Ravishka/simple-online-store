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
            <div class="product-grid">
                <div class="product-item">
                    <img src="images/product1.jpg" alt="Product 1">
                    <h3>Smart Watch</h3>
                    <p>Stay connected with this sleek smart watch.</p>
                    <a href="product_details.php?id=1" class="view-details">View Details</a>
                </div>
                <div class="product-item">
                    <img src="images/product2.jpg" alt="Product 2">
                    <h3>Wireless Headphones</h3>
                    <p>Enjoy crystal-clear sound with these wireless headphones.</p>
                    <a href="product_details.php?id=2" class="view-details">View Details</a>
                </div>
                <div class="product-item">
                    <img src="images/product3.jpg" alt="Product 3">
                    <h3>Portable Power Bank</h3>
                    <p>Keep your devices charged on the go with this power bank.</p>
                    <a href="product_details.php?id=3" class="view-details">View Details</a>
                </div>
                </div>
        </section>

        <section class="categories">
            <h2>Shop By Category</h2>
            <div class="category-grid">
                <a href="products.php?category=electronics" class="category-item">
                    <img src="images/electronics.jpeg" alt="Electronics">
                    <h3>Electronics</h3>
                </a>
                <a href="products.php?category=fashion" class="category-item">
                    <img src="images/fashion.jpg" alt="Fashion">
                    <h3>Fashion</h3>
                </a>
                <a href="products.php?category=home" class="category-item">
                    <img src="images/Home & Living.png" alt="Home & Living">
                    <h3>Home & Living</h3>
                </a>
                <a href="products.php?category=accessories" class="category-item">
                    <img src="images/accessories.png" alt="Accessories">
                    <h3>Accessories</h3>
                </a>
            </div>
        </section>

        <section class="best-sellers">
            <h2>Best Sellers</h2>
            <div class="product-grid">
                <div class="product-item">
                    <img src="images/product7.jpg" alt="Wireless Earbuds">
                    <h3>Wireless Earbuds</h3>
                    <p>Premium sound quality and comfort.</p>
                    <a href="product_details.php?id=7" class="view-details">View Details</a>
                </div>
                <div class="product-item">
                    <img src="images/product8.jpg" alt="Fitness Tracker">
                    <h3>Fitness Tracker</h3>
                    <p>Track your fitness goals with precision.</p>
                    <a href="product_details.php?id=8" class="view-details">View Details</a>
                </div>
                <div class="product-item">
                    <img src="images/product9.jpg" alt="Smart Home Speaker">
                    <h3>Smart Home Speaker</h3>
                    <p>Control your home with voice commands.</p>
                    <a href="product_details.php?id=9" class="view-details">View Details</a>
                </div>
            </div>
        </section>

        <section class="deals-of-the-day">
            <h2>Deals of the Day</h2>
            <div class="product-grid">
                <div class="product-item">
                    <img src="images/product10.jpg" alt="Portable Bluetooth Speaker">
                    <h3>Portable Bluetooth Speaker</h3>
                    <p>Enjoy your music anywhere with this speaker.</p>
                    <a href="product_details.php?id=10" class="view-details">View Details</a>
                </div>
                <div class="product-item">
                    <img src="images/product11.jpg" alt="Kitchen Utensil Set">
                    <h3>Kitchen Utensil Set</h3>
                    <p>Upgrade your kitchen with this essential set.</p>
                    <a href="product_details.php?id=11" class="view-details">View Details</a>
                </div>
                <div class="product-item">
                    <img src="images/product12.jpg" alt="Travel Backpack">
                    <h3>Travel Backpack</h3>
                    <p>Perfect for your next adventure.</p>
                    <a href="product_details.php?id=12" class="view-details">View Details</a>
                </div>
            </div>
        </section>

        <section class="our-promise">
            <h2>Our Promise</h2>
            <div class="promise-grid">
                <div class="promise-item">
                    <img src="images/promise_quality.png" alt="Quality Products">
                    <h3>Quality Products</h3>
                    <p>We source only the best products from trusted suppliers.</p>
                </div>
                <div class="promise-item">
                    <img src="images/promise_support.png" alt="Excellent Support">
                    <h3>Excellent Support</h3>
                    <p>Our team is here to help you with any questions or issues.</p>
                </div>
                <div class="promise-item">
                    <img src="images/promise_shipping.png" alt="Fast Shipping">
                    <h3>Fast Shipping</h3>
                    <p>Get your orders delivered quickly and reliably.</p>
                </div>
                <div class="promise-item">
                    <img src="images/promise_returns.png" alt="Easy Returns">
                    <h3>Easy Returns</h3>
                    <p>Hassle-free returns if you're not satisfied with your purchase.</p>
                </div>
            </div>
        </section>

        <section class="about-us">
            <h2>About Us</h2>
            <p>Welcome to our online store! We are dedicated to providing our customers with high-quality products and exceptional service. Our mission is to make online shopping easy, convenient, and enjoyable for everyone.</p>
            <p>We carefully select our products from trusted suppliers to ensure that you get the best value for your money. Whether you're looking for electronics, fashion, home goods, or more, we've got you covered.</p>
            <p>Our team is committed to providing excellent customer support. If you have any questions or need assistance, please don't hesitate to contact us. We're here to help!</p>
        </section>

        <section class="customer-testimonials">
            <h2>What Our Customers Say</h2>
            <div class="testimonial">
                <p>"I love the quality of the products and the fast shipping. Highly recommend this store!"</p>
                <p class="customer-name">- Jane Doe</p>
            </div>
            <div class="testimonial">
                <p>"Great customer service and amazing deals. Will definitely shop here again!"</p>
                <p class="customer-name">- John Smith</p>
            </div>
        </section>

        <section class="newsletter">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Stay updated with our latest offers and new arrivals.</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit" class="btn">Subscribe</button>
            </form>
        </section>

    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Online Store. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>