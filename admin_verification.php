<?php
session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_key = $_POST["admin_key"];

    // Replace 'your_secret_admin_key' with a strong, secure key
    if ($admin_key === '1234') {
        $_SESSION['admin_verified'] = true;
        $redirect_url = isset($_SESSION['admin_redirect_url']) ? $_SESSION['admin_redirect_url'] : 'login.php';
        unset($_SESSION['admin_redirect_url']);
        header("Location: " . $redirect_url);
        exit;
    } else {
        $error_message = "Invalid admin key.";
    }
} else {
    // Store the intended redirect url
    $redirect = 'login.php';
    if(isset($_GET['redirect'])){
        $redirect = $_GET['redirect'];
    }
    $_SESSION['admin_redirect_url'] = $redirect;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Verification</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="register-container">
        <h2>Admin Verification</h2>
        <?php if (!empty($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post" action="admin_verification.php">
            <div class="form-group">
                <label for="admin_key">Admin Key:</label>
                <input type="password" name="admin_key" id="admin_key" required>
            </div>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>