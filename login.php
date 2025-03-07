<?php
session_start();
include 'functions.php';

$error_message = "";

// Admin Verification Check
if (isset($_GET['admin']) && !isset($_SESSION['admin_verified'])) {
    $_SESSION['admin_redirect_url'] = 'login.php?admin=true'; // Store redirect URL
    header("Location: admin_verification.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error_message = "Username and password are required.";
    } else {
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["role"] = $row["role"];

                // Clear admin verification if it was set
                if (isset($_SESSION['admin_verified'])) {
                    unset($_SESSION['admin_verified']);
                }

                header("Location: index.php");
                exit;
            } else {
                $error_message = "Incorrect password.";
            }
        } else {
            $error_message = "Incorrect username.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post" action="login.php<?php if (isset($_GET['admin'])) { echo '?admin=true'; } ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p><a href="register.php">Don't have an account? Register</a></p>
    </div>
</body>
</html>