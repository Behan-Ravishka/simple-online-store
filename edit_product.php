<?php
session_start();
include 'functions.php';

// Check if user is admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: index.php");
    exit;
}

// Fetch product details if ID is provided
if (isset($_GET['id'])) {
    $productId = sanitizeInput($_GET['id']);
    $sql = "SELECT product_id, product_name, description, price, stock, image_url FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        $message = "<div class='error'>Product not found.</div>";
    }
    $stmt->close();

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productName = sanitizeInput($_POST["product_name"]);
        $description = sanitizeInput($_POST["description"]);
        $price = sanitizeInput($_POST["price"]);
        $stock = sanitizeInput($_POST["stock"]);
        $imageUrl = sanitizeInput($_POST["image_url"]);

        $sql = "UPDATE products SET product_name = ?, description = ?, price = ?, stock = ?, image_url = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $productName, $description, $price, $stock, $imageUrl, $productId);

        if ($stmt->execute()) {
            $message = "<div class='success'>Product updated successfully!</div>";
            //Refresh the product information after update.
            $sql = "SELECT product_id, product_name, description, price, stock, image_url FROM products WHERE product_id = ?";
            $stmt2 = $conn->prepare($sql);
            $stmt2->bind_param("i", $productId);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows == 1) {
                $product = $result2->fetch_assoc();
            }
            $stmt2->close();

        } else {
            $message = "<div class='error'>Error updating product: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
} else {
    header("Location: products.php"); // Redirect if no ID is provided
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product - Online Store</title>
    <link rel="stylesheet" href="main_page_styles.css">
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <main class="container">
        <section class="edit-product-form">
            <h2>Edit Product</h2>
            <?php if (isset($message)) echo $message; ?>
            <form method="post" action="edit_product.php?id=<?php echo $product['product_id']; ?>">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required><br>

                <label for="description">Description:</label>
                <textarea name="description" id="description"><?php echo htmlspecialchars($product['description']); ?></textarea><br>

                <label for="price">Price:</label>
                <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>

                <label for="stock">Stock:</label>
                <input type="number" name="stock" id="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required><br>

                <label for="image_url">Image URL:</label>
                <input type="text" name="image_url" id="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>"><br>

                <button type="submit" class="btn">Update Product</button>
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