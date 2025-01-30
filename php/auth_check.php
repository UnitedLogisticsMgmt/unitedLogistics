<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.html");
    exit();
}

// Check if the user has the appropriate role (e.g., admin)
if ($_SESSION['user_role'] != 'admin') {
    header("Location: ../user/access_denied.html");
    exit();
}
?>
