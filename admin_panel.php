<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: index.php");
    exit;
}
include 'functions.php';

$message = ""; //for messages to the user

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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Admin Panel</h2>
        <?php echo $message; ?>
        <div class="form-container">
            <h3>Add Product</h3>
            <form method="post" action="admin_panel.php">
                <input type="text" name="product_name" placeholder="Product Name" required><br>
                <textarea name="description" placeholder="Description"></textarea><br>
                <input type="number" name="price" placeholder="Price" required><br>
                <input type="number" name="stock" placeholder="Stock" required><br>
                <input type="submit" name="add_product" value="Add Product">
            </form>
        </div>

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
</body>
</html>