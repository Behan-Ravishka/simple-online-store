<?php
session_start();
if (isset($_SESSION["user_id"])) {
    echo "Welcome, " . $_SESSION["username"] . "!<br>";
    echo "<a href='logout.php'>Logout</a><br>";
    if($_SESSION["role"] == "admin"){
        echo "<a href='admin_panel.php'>Admin Panel</a>";
    }
} else {
    echo "<a href='register.php'>Register</a> | <a href='login.php'>Login</a>";
}
?>