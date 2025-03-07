<?php
session_start();
include 'functions.php';

// Fetch products from the database
$sql = "SELECT product_id, product_name, description, price, stock, image_url FROM products"; // Added image_url
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products - Online Store</title>
    <link rel="stylesheet" href="main_page_styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <main class="container">
        <section class="product-list">
            <h2>Our Products</h2>
            <div class="product-grid">
                <?php foreach ($products as $product) : ?>
                    <div class="product-item">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-image">
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?></p>
                        <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                        <p>Stock: <?php echo htmlspecialchars($product['stock']); ?></p>
                        <a href="product_details.php?id=<?php echo $product['product_id']; ?>" class="btn">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Online Store. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>