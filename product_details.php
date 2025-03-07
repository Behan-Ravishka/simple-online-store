<?php
session_start();
include 'functions.php';

// Fetch product details
if (isset($_GET['id'])) {
    $product_id = sanitizeInput($_GET['id']);
    $sql = "SELECT product_name, description, price, stock, image_url FROM products WHERE product_id = '$product_id'"; // Added image_url
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        header("Location: products.php"); // Redirect if product not found
        exit;
    }
} else {
    header("Location: products.php"); // Redirect if no product ID
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Online Store</title>
    <link rel="stylesheet" href="main_page_styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <main class="container">
        <section class="product-details">
            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-image-details">
            <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
            <p>Stock: <?php echo htmlspecialchars($product['stock']); ?></p>
            <a href="products.php" class="btn">Back to Products</a>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Online Store. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>