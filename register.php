<?php
session_start();
include 'functions.php';

// Admin Verification Check
if (isset($_GET['admin']) && !isset($_SESSION['admin_verified'])) {
    $_SESSION['admin_redirect_url'] = 'register.php?admin=true'; // Store redirect URL
    header("Location: admin_verification.php");
    exit;
}

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST["username"]);
    $password = $_POST["password"];
    $email = sanitizeInput($_POST["email"]);

    // Basic Validation
    if (empty($username) || empty($password) || empty($email)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statements
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");

        // Set role based on admin verification
        $role = isset($_GET['admin']) ? 'admin' : 'user';

        $stmt->bind_param("ssss", $username, $hashed_password, $email, $role);

        if ($stmt->execute()) {
            $success_message = "Registration successful!";
            header("Location: login.php");
            exit;
        } else {
            // Error handling
            if ($stmt->errno === 1062) {
                if (strpos($stmt->error, 'username') !== false) {
                    $error_message = "Username already exists. Please choose a different username.";
                } elseif (strpos($stmt->error, 'email') !== false) {
                    $error_message = "Email address already exists. Please use a different email.";
                } else {
                    $error_message = "Duplicate entry error.";
                }
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }

        $stmt->close(); // Close the statement
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="main_page_styles.css">
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <?php if (!empty($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($success_message)) : ?>
            <p class="success"><?php echo $success_message; ?></p>
            <p><a href="login.php">Login here</a></p>
        <?php endif; ?>
        <form method="post" action="register.php<?php if (isset($_GET['admin'])){echo "?admin=true";}?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <p><a href="login.php">Already have an account? Login</a></p>
    </div>
</body>
</html>