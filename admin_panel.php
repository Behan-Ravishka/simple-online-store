<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: index.php");
    exit;
}
include 'functions.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_product"])) {
        $product_name = sanitizeInput($_POST["product_name"]);
        $description = sanitizeInput($_POST["description"]);
        $price = sanitizeInput($_POST["price"]);
        $stock = sanitizeInput($_POST["stock"]);

        $sql = "INSERT INTO products (product_name, description, price, stock) VALUES ('$product_name', '$description', '$price', '$stock')";

        if ($conn->query($sql) === TRUE) {
            $message = "<div class='success'>Product added successfully!</div>";
        } else {
            $message = "<div class='error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_styles.css">
    <link rel="stylesheet" href="main_page_styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">Online Store</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <?php if (isset($_SESSION["user_id"])) : ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else : ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="admin-container">
        <h2>Admin Panel</h2>
        <?php echo $message; ?>
        <div class="admin-form-container">
            <h3>Add Product</h3>
            <form method="post" action="admin_panel.php">
                <input type="text" name="product_name" placeholder="Product Name" required><br>
                <textarea name="description" placeholder="Description"></textarea><br>
                <input type="number" name="price" placeholder="Price" required><br>
                <input type="number" name="stock" placeholder="Stock" required><br>
                <input type="submit" name="add_product" value="Add Product" class="admin-btn">
            </form>
        </div>

        <div class="admin-tables">
            <div class="admin-table">
                <h3>User Management</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["role"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No users found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="admin-table">
                <h3>Product Management</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT product_id, product_name, price, stock FROM products";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["product_id"] . "</td>";
                                echo "<td>" . $row["product_name"] . "</td>";
                                echo "<td>" . $row["price"] . "</td>";
                                echo "<td>" . $row["stock"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No products found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <a href='admin_register.php' class="admin-btn">Register Admin</a>
    </div>
</body>
</html>