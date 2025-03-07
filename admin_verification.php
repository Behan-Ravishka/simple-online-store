<?php
session_start();
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $verification_key = sanitizeInput($_POST["verification_key"]);
    $expected_key = "1234";

    if ($verification_key === $expected_key) {
        $_SESSION['admin_verified'] = true;
        $redirect_url = isset($_SESSION['admin_redirect_url']) ? $_SESSION['admin_redirect_url'] : 'register.php?admin=true';
        unset($_SESSION['admin_redirect_url']); // Clear the redirect URL
        header("Location: " . $redirect_url);
        exit;
    } else {
        $error_message = "Invalid verification key.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Verification</title>
</head>
<body>
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="admin_verification.php">
        <label for="verification_key">Verification Key:</label>
        <input type="text" name="verification_key" id="verification_key" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>