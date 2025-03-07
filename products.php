<?php
session_start();
include 'functions.php';

// Check if user is admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    $isAdmin = false;
} else {
    $isAdmin = true;
}

// Handle product removal
if (isset($_GET['remove']) && $isAdmin) {
    $productId = sanitizeInput($_GET['remove']);
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        $message = "<div class='success'>Product removed successfully!</div>";
    } else {
        $message = "<div class='error'>Error removing product: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Fetch products from the database
$sql = "SELECT product_id, product_name, description, price, stock, image_url FROM products";
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
            <?php if (isset($message)) echo $message; ?>
            <div class="product-grid">
                <?php foreach ($products as $product) : ?>
                    <div class="product-item">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-image">
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?></p>
                        <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                        <p>Stock: <?php echo htmlspecialchars($product['stock']); ?></p>
                        <a href="product_details.php?id=<?php echo $product['product_id']; ?>" class="btn">View Details</a>
                        <?php if ($isAdmin) : ?>
                            <div class="admin-actions">
                                <a href="edit_product.php?id=<?php echo $product['product_id']; ?>" class="btn edit-btn">Edit</a>
                                <a href="products.php?remove=<?php echo $product['product_id']; ?>" class="btn remove-btn" onclick="return confirm('Are you sure you want to remove this product?')">Remove</a>
                            </div>
                        <?php endif; ?>
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